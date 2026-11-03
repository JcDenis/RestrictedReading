/*global $, dotclear */
'use strict';

$(() => {
  if (typeof dotclear.ToolBar === 'function') {
    $('#RestrictedReadingpost_content').each(function () {
      const RestrictedReadingJsToolBar = new dotclear.ToolBar(this);
      RestrictedReadingJsToolBar.draw('xhtml');
    });
  }
});
