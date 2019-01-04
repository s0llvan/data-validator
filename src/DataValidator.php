<?php

namespace S0llvan\DataValidator;

class DataValidator
{
   private $data,
      $rules,
      $errors,
      $customMessages,
      $filters;

   public function __construct(array $data = [], array $rules = [], array $customMessages = [], array $filters = [])
   {
      $this->data = $data;
      $this->rules = $rules;
      $this->errors = [];
      $this->customMessages = $customMessages;
      $this->filters = $filters;
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
                     $validate = $this->applyRule($value, $rule);
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
               $filters = $this->filters[$name];
               $filters = explode('|', $filters);

               $name = $matches[1];

               if (isset($this->data[$key][$name])) {
                  $value = $this->data[$key][$name];

                  foreach ($filters as $filter) {
                     $value = $this->applyFilter($value, $filter);
                  }
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
    * Apply rule
    * 
    * @param mixed $value
    * @param string $rule
    * 
    * @return boolean
    */
   private function applyRule($value, $rule)
   {
      $validate = false;
      if ($rule) {
         list($rule, $parameters) = $this->call(Rule::class, $rule);
         $rule = __NAMESPACE__ . '\\Rule\\' . $rule;
         $validate = $rule::Apply($value, $parameters);
      }
      return $validate;
   }

   /**
    * Apply filter
    * 
    * @param mixed $value
    * @param string $filter
    * 
    * @return boolean
    */
   private function applyFilter($value, $filter)
   {
      if ($filter) {
         list($filter, $parameters) = $this->call(Filter::class, $filter);
         $filter = __NAMESPACE__ . '\\Filter\\' . $filter;
         $value = $filter::Apply($value, $parameters);
      }
      return $value;
   }

   /**
    * Call rule or filter class
    * 
    * @param string $ruleOrFilter
    * 
    * @return string $ruleOrFilter
    */
   private function call($class, string $ruleOrFilter)
   {
      $parameters = explode(':', $ruleOrFilter);

      $ruleOrFilter = $parameters[0];

      $ruleOrFilter = explode('_', $ruleOrFilter);
      $ruleOrFilter = array_map('ucfirst', $ruleOrFilter);
      $ruleOrFilter = implode('', $ruleOrFilter);

      if (count($parameters)) {
         unset($parameters[0]);
         $parameters = implode('', $parameters);
         $parameters = explode(',', $parameters);
      }

      if (!class_exists($class . '\\' . $ruleOrFilter)) {
         throw new \ErrorException($class . '\\' . $ruleOrFilter . ' class not found');
      }
      return [$ruleOrFilter, $parameters];
   }
} 