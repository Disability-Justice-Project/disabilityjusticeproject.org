(function($) {

  // Toggle accessibility settings modal
  var accessibilitySettingsToggle = $('#accessibility-settings-toggle');
  var accessibilitySettingsModal = $('#accessibility-settings-modal');

  accessibilitySettingsToggle.click(function(event) {
    if ( accessibilitySettingsModal.attr('hidden') ) {
      accessibilitySettingsModal.removeAttr('hidden');
    } else {
      accessibilitySettingsModal.prop('hidden', true);
    }
    return false;
  });

  // Toggle transcripts
  var transcriptButtons = $('[data-transcript="button"]');
  var transcriptContent = $('[data-transcript="content"]').hide();

  transcriptButtons.click(function(event) {
    var transcriptButton = $(event.target);
    var transcriptContent = transcriptButton.parents(".c-tease-project").find('[data-transcript="content"]');

    if ( transcriptButton.attr('aria-pressed') == 'false' ) {
      transcriptButton.attr("aria-pressed", "true");
      transcriptContent.attr("aria-hidden", "false");
      transcriptContent.show().focus();
      transcriptContent.get(0).scrollIntoView({behavior: "smooth"});
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
