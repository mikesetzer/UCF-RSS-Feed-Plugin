/* global wp */

(function ($) {

  $('.ucf_rss_fallback_image_upload').click((e) => {
    e.preventDefault();

    const uploader = wp.media({
      title: 'RSS Feed Fallback Image',
      button: {
        text: 'Upload Image'
      },
      multiple: false
    });

    uploader
      .on('select', () => {
        const attachment = uploader.state().get('selection').first().toJSON();
        $('.ucf_rss_fallback_image_preview').attr('src', attachment.url);
        $('.ucf_rss_fallback_image').val(attachment.id);
      })
      .open();
  });

}(jQuery));
