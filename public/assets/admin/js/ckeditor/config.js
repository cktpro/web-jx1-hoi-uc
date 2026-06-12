/**
 * @license Copyright (c) 2003-2021, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

 CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'vi';
	config.skin = 'moono-lisa';
	// config.uiColor = '#AADC6E';
	// 
// CKEDITOR.config.width = '500px';
CKEDITOR.config.height = '700px';

config.filebrowserBrowseUrl = 'js/ckfinder/ckfinder_kevin.php';
config.filebrowserImageBrowseUrl = 'js/ckfinder/ckfinder_kevin.php?type=Images';
config.filebrowserFlashBrowseUrl = 'js/ckfinder/ckfinder_kevin.php?type=Flash';
config.filebrowserUploadUrl = 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
config.filebrowserImageUploadUrl = 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
config.filebrowserFlashUploadUrl = 'js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
};

