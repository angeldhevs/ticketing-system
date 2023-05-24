"use strict";

//Create local scope to prevent polluting the global namespace.
$(function() {

  //Cache DOM references
  let $form = $('.content form');

  function initialize() {
    $form.validation({ submitHandler: handleSubmit.bind(this) });
    bindEvents();
  }

  function bindEvents() {
    $form.on('submit', submitAsync.bind(this));
  }

  function handleSubmit() {
    $.post({
      url: $form.attr('action'),
      data: $form.createObject(),
      dataType: 'json',
      success: showSuccessMessage.bind(this),
      error: showErrorMessage.bind(this)
      });
  }

  function submitAsync(e) {
    e.preventDefault();
    $form.valid();
    return false;
  }



  function showSuccessMessage(data) {
    $.alertBox('success', {
      title: 'Success!',
      message: data.message || 'Ticket successfully created!',
      onDestroy: reloadPage.bind(this)
    });
  }

  function showErrorMessage(data) {
    $.alertBox('error', {
      title: 'Oops!',
      message: data.responseJson.message || data.message || 'There was a problem creating the ticket.',
    });
  }

  function reloadPage() {
    location.reload();
  }

  initialize();

});
