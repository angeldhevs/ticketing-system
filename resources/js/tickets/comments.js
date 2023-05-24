"use strict";

//Create local scope to prevent polluting the global namespace.
$(function() {
  //Cache DOM references
  let $root = $('.comments-section');
  let $commentBoxes = $root.find('.comment-box');

  function initialize() {
    bindEvents();
    render();
  }

  function bindEvents() {
    $commentBoxes.on('keypress', 'textarea.comment', submitComment.bind(this))
  }

  function render() {
  }

  function submitComment(e) {
    if(e.keyCode === 13 && !e.shiftKey) {
      let $textarea = $(e.currentTarget);
      let $commentBox = $textarea.closest('.comment-box');

      $.post({
        url: $textarea.data('url'),
        data: {
          parent_comment_id: $textarea.parent().data('parent-comment-id'),
          comment: $textarea.val()
        },
        success: function(data, status, xhr) {
          let $p = $textarea.siblings('p.comment');
          let $replies = $textarea.siblings('.comment-list');

          $p.val(data.comment);
          $replies.attr('data-parent-comment-id', data.parent_comment_id);

          $commentBox
            .addClass('display-mode')
            .removeClass('edit-mode');
        }
      });
    }

    function appendComment(data, status, xhr) {
    }

    return true;
  }

  initialize();

});
