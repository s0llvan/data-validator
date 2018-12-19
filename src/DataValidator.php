<?php

namespace S0llvan\DataValidator;

class DataValidator
{
   private $data,
      $rules,
      $errors,
      $customMessages;

   public function __construct(array $data = [], array $rules = [], array $customMessages = [])
   {
      $this->data = $data;
      $this->rules = $rules;
      $this->errors = [];
      $this->customMessages = $customMessages;
   }

   /**
    * Check form is valid
    * 
    * @return boolean
    */
   public function isValid()
   {
      foreach ($this->data as $key => $values) {
         if (is_array($values)) {
            foreach ($values as $name => $value) {
               $ruleKey = $key . '[' . $name . ']';
               if (array_key_exists($ruleKey, $this->rules)) {
                  $rules = $this->rules[$ruleKey];
                  $rules = explode('|', $rules);
                  foreach ($rules as $rule) {
                     $validate = $this->validateRule($value, $rule);
                     if (!$validate) {
                        $message = $this->messageRule($ruleKey, $rule);
                        $this->errors[$name][$rule] = $message;
                     }
                  }
               }
            }
         }
      }
      return count($this->errors) <= 0 && count($this->data);
   }

   /**
    * Check form is submit
    * 
    * @return boolean
    */
   public function isSubmit()
   {
      $submit = false;
      if (count($this->data)) {
         foreach ($this->rules as $name => $value) {
            preg_match('/[A-Za-z0-9]*/', $name, $matches);

            if ($matches) {
               $key = $matches[0];

               if (preg_match('/\[([^\]]*)\]/', $name, $matches)) {
                  if (isset($matches[1])) {
                     $name = $matches[1];

                     if (isset($this->data[$key])) {
                        if (!isset($this->data[$key][$name])) {
                           $submit = false;
                           break;
                        }
                     } else {
                        $submit = false;
                        break;
                     }

                     $submit = true;
                  }
               }
            }
         }
      }
      return $submit;
   }

   /**
    * Field error
    *
    * @param string $name
    *
    * @return string
    */
   public function get($name)
   {
      $value = null;

      preg_match('/[A-Za-z0-9]*/', $name, $matches);

      if ($matches) {
         $key = $matches[0];
         if (preg_match('/\[([^\]]*)\]/', $name, $matches)) {
            if (isset($matches[1])) {
               $name = $matches[1];
               if (isset($this->data[$key][$name])) {
                  $value = $this->data[$key][$name];
               }
            }
         }
      } else {
         $value = $this->data[$name];
      }

      return $value;
   }

   /**
    * All errors
    * 
    * @return array
    */
   public function all()
   {
      return $this->errors;
   }

   /**
    * First error
    * 
    * @return string
    */
   public function first()
   {
      $error = null;
      $name = key($this->errors);
      if ($name) {
         $rule = key($this->errors[$name]);
         if ($rule) {
            $error = isset($this->errors[$name][$rule]) ? $this->errors[$name][$rule] : null;
         }
      }
      return $error ?? $name;
   }

   /**
    * Custom error message
    * 
    * @param string $ruleKey
    * @param string $rule
    * 
    * @return string
    */
   private function messageRule(string $ruleKey, string $rule)
   {
      $customMessageIndex = $ruleKey . '.' . $rule;
      $customMessageIndex = explode(':', $customMessageIndex)[0];

      if (array_key_exists($customMessageIndex, $this->customMessages)) {
         return $this->customMessages[$customMessageIndex];
      }
      return null;
   }

   /**
    * Validate rule
    * 
    * @param mixed $value
    * @param string $rule
    * 
    * @return boolean
    */
   private function validateRule($value, $rule)
   {
      $validate = false;
      if ($rule) {
         list($rule, $parameters) = $this->call($rule);
         $rule = __NAMESPACE__ . '\\Rule\\' . $rule;
         $validate = $rule::Validate($value, $parameters);
      }
      return $validate;
   }

   /**
    * Call rule class
    * 
    * @param string $rule
    * 
    * @return string $rule
    */
   private function call(string $rule)
   {
      $parameters = explode(':', $rule);

      $rule = $parameters[0];

      $rule = explode('_', $rule);
      $rule = array_map('ucfirst', $rule);
      $rule = implode('', $rule);

      if (count($parameters)) {
         unset($parameters[0]);
         $parameters = implode('', $parameters);
         $parameters = explode(',', $parameters);
      }

      if (!class_exists(__NAMESPACE__ . '\\Rule\\' . $rule)) {
         throw new \ErrorException(__NAMESPACE__ . '\\Rule\\' . $rule . ' class not found');
      }
      return [$rule, $parameters];
   }
} 