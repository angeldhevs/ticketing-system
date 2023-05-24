/*!
 * form-validation v1.0.0
 * A wrapper for jquery validation that uses html5's data annotation.
 * Author: Benedict Semilla
 * Contact: benedict.11394@gmail.com
 */
; (function($, undefined) {
  let pluginName = "validation";

  let defaults = {
    validation: {
      errorElement: 'small',
      errorClass: 'invalid',
      validClass: 'valid'
    },
    dataAttr: {
      prefix: 'data-validation-'
    }
  }

  function Plugin(element, options) {
    this._element = element;
    this._defaults = defaults;
    this.options = $.extend(true, this._defaults, options);
    this.init();
  }

  $.extend(Plugin.prototype, {
    init: function() {
      this.buildCache();
      this.buildValidation();
      this.render();
    },
    buildCache: function() {
      this.$form = $(this._element);
      this.$fields = this.$form.find(':input:enabled:not(button)');
    },
    buildValidation: function() {
      let validation = this.$fields
        .get()
        .map(getFieldRules.bind(this))
        .filter(hasRules)
        .reduce(aggregateFieldRules.bind(this), { rules: {}, messages: {} });

      $.extend(this.options.validation, validation);
    },
    render: function() {
      this.$form.validate(this.options.validation);
    }
  });

  function getFieldRules(element) {
    let name = element.getAttribute('name');

    let rules = Array.from(element.attributes)
      .filter(isValidationData.bind(this))
      .reduce(getValidationData.bind(this), {});

    return {
      name: name,
      rules: rules
    };
  }

  function isValidationData(attr) {
    return attr.specified && attr.name.indexOf(this.options.dataAttr.prefix) >= 0;
  }

  function hasRules(fieldData) {
    return Object.keys(fieldData.rules).length > 0 && fieldData.rules.constructor === Object
  }

  function getValidationData(rules, attr) {

    let ruleName = attr.name
      .replace(this.options.dataAttr.prefix, '')
      .replace('-', '_')
      .trim()
      .toLowerCase();

      rules[ruleName] = attr.value;

      return rules;
  }

  function aggregateFieldRules(agg, field) {
    let rules = {};
    for(let key in field.rules) {
      rules[key] = true;
    }

    agg.rules[field.name] = rules;
    agg.messages[field.name] = field.rules;

    return agg;
  }
  // A really lightweight plugin wrapper around the constructor,
  // preventing against multiple instantiations
  $.fn[pluginName] = function (options) {
    this.each(function () {
      if (!$.data(this, "plugin_" + pluginName)) {
          $.data(this, "plugin_" + pluginName, new Plugin(this, options));
      }
    });

    return this;
  };

})(jQuery);


