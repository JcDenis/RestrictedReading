/*global $, dotclear, jsToolBar */
'use strict';

$(() => {
  if (typeof jsToolBar === 'function') {
    $('#RestrictedReadingpost_content').each(function () {
      const RestrictedReadingJsToolBar = new jsToolBar(this);
      RestrictedReadingJsToolBar.draw('xhtml');
    });
  }
});
