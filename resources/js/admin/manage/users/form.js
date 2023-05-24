"use strict";

//Create local scope to prevent polluting the global namespace.
$(function() {

  //Cache DOM references
  let $form = $('.content form');

  function initialize() {
    $form.validation();
    bindEvents();
  }

  function bindEvents() {
    $form.on('submit', submitAsync.bind(this));
  }

  function handleSubmit() {
    $.ajax({
      type: $form.data('method'),
      url: $form.attr('action'),
      data: $form.createObject(),
      dataType: 'json',
      success: showSuccessMessage.bind(this),
      error: showErrorMessage.bind(this),
      complete: function() {
        $.spinner('hide');
      }
    });
  }

  function submitAsync(e) {
    return $form.valid();
  }

  function showSuccessMessage(data, status, xhr) {
    $.alertBox('success', {
      title: 'Success!',
      content: data.message || 'Operation completed successfully!',
      onDestroy: reloadPage
    });
  }

  function showErrorMessage(data, status, xhr) {
    $.alertBox('error', {
      title: 'Oops!',
      content: data.message || 'There was a problem performing the operation. Please try again.',
      onDestroy: reloadPage
    });
  }

  function reloadPage() {
    window.location.replace('../');
  }

  initialize();
});
