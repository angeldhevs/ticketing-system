"use strict";

//Define module constants.
const __CONSTANTS = Object.freeze({
  //Constant values for modal.
  MODAL: {
    SELECTOR: "#ticket-modal",
    MODE: {
      HIDDEN: "hidden",
      CREATE: "create",
      VIEW: "view",
      UPDATE: "update",
      ASSIGN: "assign",
      STATUS_UPDATE: "status_update"
    },
    DATA: {
      MODE: "mode",
    }
  },
  //Constant values for fields.
  FIELD: {
    SELECTOR: "input,select,textarea",
    VALUES: {
      OLD: "old-value",
      DEFAULT: "default-value",
    },
    MAP_FROM: "map-from",
    DISABLE_ON: "disable-on",
    DIRTY: "dirty",
    OPTION: {
      SOURCE: "options-url",
      VALUE: "option-value",
      TEXT: "option-text"
    }
  },
  //Constant values for ticket.
  TICKET: {
    DATA: "ticket-data",
    RESOURCE_URL: "resource-url",
    DETAILS: "ticket_details"
  }
});

//Object for handling AJAX request.
const AJAX = Object.freeze({
  defaults: {
    beforeSend: function (xhr) {
      $.spinner('show', __CONSTANTS.MODAL.SELECTOR);
      xhr.setRequestHeader("Authorization", "Bearer " + $('meta[name="api-token"]').attr("content"));
    },
    complete: function () {
      $.spinner('hide', __CONSTANTS.MODAL.SELECTOR);
    },
    error: function (xhr, message, status) {
      console.log(xhr, message, status);
    }
  },
  create: function (settings) {
    return $.extend(true, {
      type: this.evaluateRequestType()
    }, this.defaults, settings);
  },
  submit: function (settings) {
    let config = this.create(settings);
    return $.ajax(config);
  },
  evaluateRequestType: function () {
    switch ($modal.data(__CONSTANTS.MODAL.DATA.MODE)) {
      case __CONSTANTS.MODAL.MODE.CREATE:
        return "POST";
      case __CONSTANTS.MODAL.MODE.UPDATE:
        return "PUT";
      case __CONSTANTS.MODAL.MODE.ASSIGN:
      case __CONSTANTS.MODAL.MODE.STATUS_UPDATE:
        return "PATCH";
      default:
        return "GET";
    }
  }
});

//Cache DOM references
let $modal = $(__CONSTANTS.MODAL.SELECTOR);
let $form = $modal.find("form");
let $editBtn = $form.find(".btn-edit");
let $fields = $form.find(__CONSTANTS.FIELD.SELECTOR);

//Bind events
$form.on("submit", submitAsync.bind(this));
$form.on("reset", resetForm.bind(this));
$form.on("focusin click", "input, select", storeOldValue.bind(this));
$form.on("change", "input, select", markIfDirty.bind(this));
$form.on("click", "[data-mode]:not(.btn-save,.btn-cancel)", renderModal.bind(this));
$form.on("click", "[data-mode=status_update]", updateStatus.bind(this));
$form.on("click", ".status-btns > .btn-save", saveStatus.bind(this));
$form.on("click", ".btn-cancel", cancelUpdate.bind(this));
$modal.on("show.bs.modal", renderModal.bind(this));
$modal.on("hidden.bs.modal", resetModal.bind(this));

//Initialize
$form.validation();
let validator = $form.data('validator');
initializeSelectFieldOptions();

function renderModal(e) {
  prepareModal(e);
  getTicketData()
    .done(setFormData.bind(this))
    .done(updateControlStates.bind(this));
}

function prepareModal(e) {
  let $trigger = $(e.relatedTarget || e.currentTarget);
  let mode = $trigger.data(__CONSTANTS.MODAL.DATA.MODE);
  validator.resetForm();

  $modal
    .attr("data-mode", mode)
    .data(__CONSTANTS.MODAL.DATA.MODE, mode);
  $form.data(__CONSTANTS.TICKET.RESOURCE_URL, $trigger.data(__CONSTANTS.TICKET.RESOURCE_URL));
}

function submitAsync(e) {
  e.preventDefault();
  let mode = $modal.data(__CONSTANTS.MODAL.DATA.MODE);
  let data = $modal.data(__CONSTANTS.TICKET.DATA);
  let url = data ? data.links[mode] : $modal.data('create-url');
  if ($form.valid()) {
    AJAX.submit({
      url: url,
      data: createFormObject()
    })
    .done(function (data, status) {
      e.relatedTarget = $form.find('[type="submit"]').get(0);
      $modal.removeData(__CONSTANTS.TICKET.DATA);
      renderModal(e);
      $modal.trigger('ticket.' + mode, [data, status]);
    }.bind(this));
  }
  return false;
}

function getTicketData() {
  let deferred = $.Deferred();
  let mode = $modal.data(__CONSTANTS.MODAL.DATA.MODE);

  if ($form.data(__CONSTANTS.TICKET.RESOURCE_URL)
    && [__CONSTANTS.MODAL.MODE.VIEW, __CONSTANTS.MODAL.MODE.ASSIGN].includes(mode)) {
    return AJAX
      .submit({
        url: $form.data(__CONSTANTS.TICKET.RESOURCE_URL),
        type: 'GET'
      })
      .done(function (data) {
        deferred.resolve(data);
        return deferred.promise();
      }.bind(this))
      .fail(function () {
        deferred.reject();
        return deferred.promise();
      });
  } else {
    let data = mode == __CONSTANTS.MODAL.MODE.VIEW || mode == __CONSTANTS.MODAL.MODE.EDIT ?
      $modal.data(__CONSTANTS.TICKET.DATA) : null;
    deferred.resolve(data);
    return deferred.promise();
  }
}

function resetModal() {
  $modal.attr("data-mode", __CONSTANTS.MODAL.MODE.HIDDEN);
  $modal.removeData(__CONSTANTS.MODAL.DATA);
  $form.trigger("reset");
  window.history.pushState({}, document.title, "/tickets");
}

function setFormData(dt) {
  dt = dt || $modal.data(__CONSTANTS.TICKET.DATA) || null;

  if (dt) {
    $modal
      .data(__CONSTANTS.TICKET.DATA, dt);
    $modal
      .find(".modal-title-text")
      .text(`Ticket #${dt.data.ticket_number}`);
    $modal
      .find("[data-tab=comments]")
      .attr("data-resource-url", dt.links.comments);
    $modal
      .find("[data-tab=activities]")
      .attr("data-resource-url", dt.links.activities);

  window.history.pushState(dt, document.title, "/tickets?id=" + dt.data.id);
}

  $fields.each(function (index, element) {
    let $element = $(element);
    let name = $element.data(__CONSTANTS.FIELD.MAP_FROM) || $element.attr("name");
    let value = dt ? _.get(dt.data, name) : $element.data(__CONSTANTS.FIELD.VALUES.OLD) || $element.data(__CONSTANTS.FIELD.VALUES.DEFAULT);

    $element.val(value).trigger("change");
  });

  TinyMCE
    .get(__CONSTANTS.TICKET.DETAILS)
    .setContent(dt ? dt.data.details || "" : "");

}

function updateControlStates() {
  let mode = $modal.data(__CONSTANTS.MODAL.DATA.MODE);
  let data = $modal.data(__CONSTANTS.TICKET.DATA);
  $fields
    .filter(':not([type=hidden])')
    .each(function (index, field) {
      let $this = $(field);
      let disableOn = $this.data(__CONSTANTS.FIELD.DISABLE_ON);
      let isReadOnly =
        (($this.attr('data-editable') !== undefined && !$this.data("editable")) ||
          __CONSTANTS.MODAL.MODE.VIEW === mode ||
          __CONSTANTS.MODAL.MODE.HIDDEN === mode ||
          (disableOn && disableOn.split(",").some(function (txt) {
            return txt === mode;
          })));

      $this
        .prop("readonly", isReadOnly)
        .prop("disabled", isReadOnly)
        .toggleClass("readonly", isReadOnly)
        .toggleClass("form-control", !isReadOnly)
        .toggleClass("form-control-plaintext", isReadOnly);

      if ($this.attr('name') == __CONSTANTS.TICKET.DETAILS) {
        TinyMCE.get(__CONSTANTS.TICKET.DETAILS).setMode(isReadOnly ? "readonly" : "design");
      }
    });

    if(mode === __CONSTANTS.MODAL.MODE.ASSIGN) {
      let $reporterId = $fields.filter('[name=reporter_id]');
      let $reporter = $fields.filter('[name=reporter_name]');
      let $assignee = $fields.filter('[name=assignee_id]');

      $reporterId.val($reporterId.data('default-value'));
      $reporter.val($reporter.data('default-value'));
      $assignee.val($assignee.data('default-value'));
  }

  if(data) {
    $editBtn.prop('disabled', !data.data.assignee || data.data.assignee.id !== window.__App.User.id);
    $modal.find('.btn-assign').toggle(!!(data && (mode === __CONSTANTS.MODAL.MODE.VIEW && !data.data.assignee)));
  }
}

function resetForm(e) {
  e.preventDefault();
  $form.data("validator").resetForm();

  initializeSelectFieldOptions()
    .then(setFormData.call(this, null));
}

function initializeSelectFieldOptions() {
  let deferred = $.Deferred();

  let promises = $fields
    .filter(`[data-${__CONSTANTS.FIELD.OPTION.SOURCE}]`)
    .map(function (index, element) {
      return getSelectFieldOptions.call(this, element)
        .then(setSelectFieldOptions.bind(element));
    }.bind(this))
    .get();

  return $.when.apply($, promises)
    .done(function () {
      deferred.resolve(this);
      return deferred.promise();
    }.bind(this))
    .fail(function () {
      deferred.reject(this);
      return deferred.promise();
    }.bind(this));
}

function getSelectFieldOptions(element) {
  let $element = $(element);

  return AJAX.submit({
    type: "GET",
    url: $element.data(__CONSTANTS.FIELD.OPTION.SOURCE)
  });
}

function setSelectFieldOptions(data) {
  let $this = $(this);
  let options = Array.isArray(data) ? data : [data];

  $this.find('option:not(:first)').remove();

  let $options = options
    .map(function (option) {
      let val = option[$this.data(__CONSTANTS.FIELD.OPTION.VALUE) || "val"];
      let txt = option[$this.data(__CONSTANTS.FIELD.OPTION.TEXT) || "text"];
      let $option = $("<option>", {
        value: val,
        text: txt
      });
      return $option;
    }.bind(this));

  $this
    .append($options)
    .val($this.val() || $this.data(__CONSTANTS.FIELD.VALUES.OLD) || $this.data(__CONSTANTS.FIELD.VALUES.DEFAULT) || null);

  if (!$this.val()) {
    let value = (data.length === 1 ? data[0][$this.data(__CONSTANTS.FIELD.OPTION.VALUE) || "val"] : null);
    $this.val(value);
  }
}

function storeOldValue(e) {
  let $field = $(e.currentTarget);
  $field.data(__CONSTANTS.FIELD.VALUES.OLD, $field.val());
}

function markIfDirty(e) {
  let $field = $(e.currentTarget);
  let isDirty = !!($field.data(__CONSTANTS.FIELD.VALUES.OLD) && $field.data(__CONSTANTS.FIELD.VALUES.OLD) !== $field.val());
  $field.attr(__CONSTANTS.FIELD.DIRTY, isDirty);
}

function updateStatus(e) {
  let $trigger = $(e.currentTarget);
  let $wrapper = $trigger.closest('.form-group');
  let $select = $wrapper.find('select');
  let $selected = $select.find('option:selected');

  $wrapper
    .find('.prev-status .status-name span')
    .text($selected.text());

  $select
    .data('old', $selected.val())
    .find('option:not(:first)')
    .remove();

  AJAX.submit({
    type: "GET",
    url: $select.data(__CONSTANTS.FIELD.OPTION.SOURCE),
    data: { after: $selected.text() },
    success: function (data) {
      setSelectFieldOptions.call($select, data);
      updateControlStates();
    }.bind(this)
  });
}

function saveStatus(e) {
  if ($form.valid()) {
    let $trigger = $(e.currentTarget);
    let $wrapper = $trigger.closest('.form-group');
    let $select = $wrapper.find('select');
    let data = $modal.data(__CONSTANTS.TICKET.DATA);

    AJAX.submit({
      type: "PATCH",
      url: data.links[__CONSTANTS.MODAL.MODE.STATUS_UPDATE],
      data: {
        status_id: $select.val()
      }
    })
    .done(function (data, status) {
      prepareModal(e);
      getSelectFieldOptions($select)
        .then(setSelectFieldOptions.bind($select))
        .then(function () { setFormData.call(this, data); }.bind(this))
        .then(updateControlStates.bind(this));
      $modal.trigger('ticket.update', [data, status]);
    }.bind(this))
    .fail(function (xhr, status, message) {
      console.log(status, message);
    });
  }
}

function cancelUpdate(e) {
  // let $trigger = $(e.currentTarget);
  // let $wrapper = $trigger.closest('.form-group');
  // let $select  = $wrapper.find('select');

  prepareModal(e);
  initializeSelectFieldOptions()
    // getSelectFieldOptions($select)
    //   .then(setSelectFieldOptions.bind($select))
    .then(setFormData.bind(this))
    .then(updateControlStates.bind(this));
}

function initTicketAssignment(e) {

}

function createFormObject() {
  let data = $form
    .createObject(function (dt) {
      dt.ticket_details = TinyMCE
        .get(__CONSTANTS.TICKET.DETAILS)
        .getContent({ format: "raw" });
      return dt;
    }.bind(this));

  return data;
}
