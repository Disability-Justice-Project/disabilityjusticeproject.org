(function($) {

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


})(jQuery);
