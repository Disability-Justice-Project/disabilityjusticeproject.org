(function($) {

  // Toggle transcripts
  var transcriptButtons = $('[data-transcript="button"]');
  var transcriptTitle = $('[data-transcript="title"]');
  var transcriptContent = $('[data-transcript="content"]').hide();

  transcriptButtons.click(function(event) {
    var transcriptButton = $(event.target);
    var transcriptContent = transcriptButton.parents(".c-tease-project").find('[data-transcript="content"]');

    if ( transcriptButton.attr('aria-pressed') == 'false' ) {
      transcriptButton.attr("aria-pressed", "true");
      transcriptContent.attr("aria-hidden", "false").slideDown();
      transcriptTitle.focus();
    } else {
      transcriptButton.attr("aria-pressed", "false");
      transcriptContent.attr("aria-hidden", "true");
      transcriptContent.hide();
      transcriptButton.focus();
    }
    return false;
  });



  // Toggle accessibility settings modal
  var accessibilitySettingsToggle = $('#accessibility-settings-toggle');
  var accessibilitySettingsModal = $('#accessibility-settings-modal').hide();
  var accessibilitySettingsModalTitle = $('#accessibility-settings-modal-title');

  accessibilitySettingsToggle.click(function(event) {
    if ( accessibilitySettingsModal.attr('hidden') ) {
      accessibilitySettingsToggle.attr("aria-expanded", "true");
      accessibilitySettingsModal.removeAttr('hidden');
      accessibilitySettingsModal.slideDown();
      accessibilitySettingsModalTitle.focus();
    } else {
      accessibilitySettingsModal.prop('hidden', true);
      accessibilitySettingsModal.hide();
      accessibilitySettingsToggle.attr("aria-expanded", "false");
      accessibilitySettingsToggle.focus();
    }
    return false;
  });

  var accessibilitySettingsCloseButton = $('[data-modal-close-button]');
  accessibilitySettingsCloseButton.click(function(event) {
    accessibilitySettingsModal.prop('hidden', true);
    return false;
  });


  // Check and set defaults
  var fontSizeDefault = $('#font-size-default').prop("checked", true);
  var lineHeightDefault = $('#line-height-default').prop("checked", true);
  var contrastDefault = $('#contrast-default').prop("checked", true);
  var noHighlight = $('#no-highlight').prop("checked", true);
  $(document.body).addClass('js-font-size-default js-line-height-default js-contrast-default');


  // Toggle font size settings
  $('input[name="font-size"]').change(function(){
    var inputVal = $('input[name="font-size"]:checked').val();
    $(document.body)
      .removeClass('js-font-size-default js-font-size-large js-font-size-extra-large')
      .addClass("js-" + inputVal);
  });

  // Toggle line height settings
  $('input[name="line-height"]').change(function(){
    var inputVal = $('input[name="line-height"]:checked').val();
    $(document.body)
      .removeClass('js-line-height-default js-line-height-more js-line-height-max')
      .addClass("js-" + inputVal);
  });


  // Toggle contrast settings
  $('input[name="contrast"]').change(function(){
    var inputVal = $('input[name="contrast"]:checked').val();
    $(document.body)
      .removeClass('js-contrast-default js-contrast-yellow js-contrast-white js-contrast-blue')
      .addClass("js-" + inputVal);
  });

  // Toggle highlight style settings
  $('input[name="highlight-style"]').change(function(){
    var inputVal = $('input[name="highlight-style"]:checked').val();
    $(document.body)
      .removeClass('js-no-highlight js-highlighted')
      .addClass("js-" + inputVal);
  });

  // Restores default accessibility modal settings
  var accessibilitySettingsResetButton = $('[data-modal-button-reset]');
  accessibilitySettingsResetButton.click(function(event) {
    $(document.body)
      .removeClass('js-font-size-default js-font-size-large js-font-size-extra-large js-line-height-default js-line-height-more js-line-height-max js-contrast-default js-contrast-yellow js-contrast-white js-contrast-blue js-no-highlight js-highlighted')
      .addClass('js-font-size-default js-line-height-default js-contrast-default js-no-highlight');
    fontSizeDefault.prop("checked", true);
    lineHeightDefault.prop("checked", true);
    contrastDefault.prop("checked", true);
    noHighlight.prop("checked", true);
    return false;
  });


})(jQuery);
