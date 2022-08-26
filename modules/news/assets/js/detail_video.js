run_video_detail();
function run_video_detail(){
	var video = $('#video_detail_link').val();
	var img = $('#img_detail_link').val();
//        alert(img);
    if( img != ""){
		jwplayer("video_detail_area_player").setup({
	        file: video,
	        image: img,
	        width: "100%",
	        aspectratio: "16:9",
            autostart: false,
	    });
  	}else{
    	jwplayer("video_detail_area_player").setup({
	        file: video,
	        width: "100%",
	        aspectratio: "16:9",
            autostart: false,
	    });
  	}
}
