$(function() {
  let $body = $('body');
  let $navbar = $body.find('nav.navbar');

  function initialize() {
    bindEvents();
    render();
  }

  function bindEvents() {
    $navbar.on('click', '[data-target]', toggleNav.bind(this));
  }

  function render() {
    
  }

  function toggleNav(evt) {
    let $toggler = $(evt.currentTarget);
    let $target = $body.find($toggler.data('target'));
    $toggler.find('.fa').toggleClass('fa-flip-horizontal');
    $target.toggleClass($toggler.data('toggle-class'));
  }

  initialize();
});