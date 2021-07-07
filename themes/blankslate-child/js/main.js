(function($) {

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

  var accessibilitySettingsCloseButton = $('[data-modal-close-button]');
  accessibilitySettingsCloseButton.click(function(event) {
    accessibilitySettingsModal.prop('hidden', true);
    return false;
  });

})(jQuery);
