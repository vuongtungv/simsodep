/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    //Define changes to default configuration here. For example:
    config.language = 'vi';
    //config.uiColor = '#AADC6E';
	//config.extraPlugins = ‘locationmap’;
	config.locationMapPath = '../libraries/ckeditor/plugins/locationmap/';
	config.filebrowserBrowseUrl      = '../libraries/ckeditor/plugins/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '../libraries/ckeditor/plugins/ckfinder/ckfinder.html?type=Images';
	config.filebrowserFlashBrowseUrl = '../libraries/ckeditor/plugins/ckfinder/ckfinder.html?type=Flash';
	config.filebrowserUploadUrl      = '../libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = '../libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = '../libraries/ckeditor/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
    
    config.htmlEncodeOutput = false;
    config.entities = false;
    config.allowedContent=true;
    config.extraAllowedContent = 'style;*[id,rel](*){*}';//
    config.removeFormatAttributes = '';
};
