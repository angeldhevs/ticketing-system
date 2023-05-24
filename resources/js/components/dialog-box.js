/*!
 * dialog-box v1.0.0
 * Author: Benedict Semilla
 * Contact: benedict.11394@gmail.com
 */
(function ($, undefined) {
  if ($ === undefined) {
  throw new Error('Cannot initialize plugin. jquery is not loaded.');
  }

  if ($.fn.confirm === undefined) {
  throw new Error('Cannot initialize jquery-confirm extension. jquery-confirm not found.');
  }

  let options = {
      defaults: {
          animation: 'opacity',
          closeAnimation: 'opacity',
          escapeKey: true,
          backgroundDismiss: true,
          typeAnimated: true,
          draggable: false
      },
      types: {
          success: {
              type: 'green',
          },
          warn: {
              type: 'orange',
          },
          error: {
              type: 'red'
          },
          info: {
              type: 'blue'
          }
      }
  };

  let dialogs = {
      confirm: {
          show: function (type, settings) {
              $.confirm(getExtendedSettings(type, settings));
          },
          success: function (settings) {
              this.show('success', settings);
          },
          error: function (settings) {
              this.show('error', settings);
          },
          warn: function (settings) {
              this.show('warn', settings);
          },
          info: function (settings) {
              this.show('info', settings);
          }
      },
      alert: {
          show: function (type, settings) {
              $.alert(getExtendedSettings(type, settings));
          },
          success: function (settings) {
              this.show('success', settings);
          },
          error: function (settings) {
              this.show('error', settings);
          },
          warn: function (settings) {
              this.show('warn', settings);
          },
          info: function (settings) {
              this.show('info', settings);
          },
      }
  };

  function getExtendedSettings(type, settings) {
      return $.extend(true, {},
          options.defaults,
          settings,
          options.types[type]);
  }

  $.confirmBox = function (type, settings) {
      if (typeof type === typeof string
          && !dialogs.confirm.hasOwnProperty(type.toLowerCase())) {
          throw new Error('Unknown confirmation message type: ', type);
      }

      return dialogs.confirm[type](settings);
  }

  $.alertBox = function (type, settings) {
      if (typeof type === typeof string
          && !dialogs.confirm.hasOwnProperty(type.toLowerCase())) {
          throw new Error('Unknown alert message type: ', type);
      }

      return dialogs.alert[type](settings);
  }
})( jQuery );