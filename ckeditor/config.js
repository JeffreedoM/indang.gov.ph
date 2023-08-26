/**
 * @license Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function (config) {
  // Define changes to default configuration here. For example:
  // config.language = 'fr';
  // config.uiColor = '#AADC6E';
  CKEDITOR.on("dialogDefinition", function (ev) {
    // Check if the dialog being defined is the "image" dialog
    if (ev.data.name === "image") {
      var dialogDefinition = ev.data.definition;

      // Find the width and height inputs in the dialog
      var widthInput = dialogDefinition.getContents("info").get("txtWidth");
      var heightInput = dialogDefinition.getContents("info").get("txtHeight");

      // Change the labels of the width and height inputs
      widthInput.label = "Width (px)";
      heightInput.label = "Height (px)";
    }
  });
};
