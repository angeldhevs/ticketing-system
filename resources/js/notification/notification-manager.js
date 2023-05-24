"use strict";



$(function () {

  const CH_MGR = require('../notification/channel-manager');
  const ITEM_TEMPLATE = `<a class="dropdown-item unread" href="{{&url}}">
        <span class="notification-message">{{message}}</span>
        <small class="notification-time">{{timestamp}}</small>
      </a>`;
  const NOTIF_COUNT = "notification-count";

  let $root = $(".notifications");
  let $trigger = $root.find(".notification-toggle");
  let $counters = $root.find(".notification-count");
  let $content = $root.find(".dropdown-content");

  function initialize() {
    bindEvents();
    registerListeners();
    render();
  }

  function bindEvents() {
    $root.on("shown.bs.dropdown", getUnreadNotifications.bind(this));
    $content.on("click", "a", openNotification.bind(this));
  }

  function render() {
    $root.removeData('notifications');
    getUnreadNotifications({
      relatedTarget: $trigger
    });
  }

  function registerListeners() {
    CH_MGR.channels.user.notification(render.bind(this));
  }

  function getUnreadNotifications(e) {
    let $target = $(e.relatedTarget);
    $.get($target.data("resource-url"), renderNotifications.bind(this));
  }

  function renderNotifications(notifications) {
    if ($root.data("notifications")) {
      return false;
    }

    let hasNotifications = notifications.length > 0;

    $counters
      .data(NOTIF_COUNT, notifications.length)
      .text(notifications.length);

    $content
      .toggleClass("no-notifications", !hasNotifications)
      .find(":not(:first)")
      .remove();

    notifications
      .map(createNotificationItem.bind(this))
      .reduce(function (container, item) {
        container.append(item);
        return container;
      }, $content);

    $root.data("notifications", notifications);
  }

  function openNotification(e) {
    let $target = $(e.currentTarget);

    if ($target.hasClass("unread")) {
      let notification = $target.data("notification");
      let count = $counters.data(NOTIF_COUNT);

      //Mark notification as read if successfully posted.
      $.post(
        notification.read_url,
        function () {
          $target.removeClass("unread");
          count--;
          $counters.data(NOTIF_COUNT, count).text(count);
        }.bind(this)
      );
    }

    return true;
  }

  function createNotificationItem(notification) {
    console.log(notification);

    let view = {
      url: notification.data.url,
      message: notification.data.message,
      timestamp: moment(notification.created_at).fromNow()
    };

    let $notification = $(mustache.render(unescape(ITEM_TEMPLATE), view));
    $notification.data("notification", notification);
    return $notification;
  }

  initialize();
});
