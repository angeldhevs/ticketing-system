/*!
 * extension-methods v1.0.0
 * Author: Benedict Semilla
 * Contact: benedict.11394@gmail.com
 */
; (function($, undefined) {
  let options = {
    regex: {
      regularCase: new RegExp('/(\w+)(\s+)(\w+)/g'),
      pascalCase: new RegExp('/(\w+)(\s+)(\w+)/g'),
      snakeCase: new RegExp()
    }
  }

 /**
  * Creates a javascript object using the form fields.
  */
 $.fn.createObject = function(callback) {
    let data = $(this)
      .serializeArray()
      .reduce(function(a, x) {
          a[x.name] = x.value;
          return a;
      }, {});

      if(callback && $.isFunction(callback)) {
        return callback(data) || data;
      } else {
        return data;
      }
  }

  /**
   * Converts a string to kebab case.
   */
  String.prototype.spaceToKebabCase = function() { 
    return this.trim().replace(/(\s+)/g, '-').toLowerCase();
  }

   /**
   * Converts a string to kebab case.
   */
  String.prototype.camelToKebabCase = function() { 
    return this.trim().replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
  }

})(jQuery);




