/*!
 * spinner v1.0.0
 * Author: Benedict Semilla
 * Contact: benedict.11394@gmail.com
 */
; (function ($, undefined) {
  if ($ === undefined) {
      throw new Error('Cannot initialize plugin. jQuery is not loaded.');
  }

  // let $body = $('body');
  // let $spinner = $body.find('.spinner');

  // if (!$spinner.get(0)) {
  //     throw new Error("Cannot initialize spinner. #spinner not found!");
  // }

  $.spinner = function (action, parent, text) {
    let $spinner = $(parent || 'body').find('.spinner');

    if (text !== undefined
      && typeof text === typeof string
      && text.length > 0) {
      $spinner.find('.text').text(text);
    }

    switch (action) {
      case "show":
        $spinner.addClass("show");
        break;
      case "hide":
        $spinner.removeClass("show");
        break;
      case "hide":
        $spinner.toggleClass("show");
        break;
      default:
        $spinner.toggleClass("show");
        break;
    }
  }
})(jQuery);
