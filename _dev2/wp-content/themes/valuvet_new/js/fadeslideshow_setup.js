/***********************************************
* Ultimate Fade In Slideshow v2.0- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for this script and 100s more
* http://www.dynamicdrive.com/dynamicindex14/fadeinslideshow.htm
* ["path_to_image", "optional_url", "optional_linktarget", "optional_description"]
***********************************************/



var mygallery=new fadeSlideShow({
	wrapperid: "headershow", //ID of blank DIV on page to house Slideshow
	dimensions: [346, 100], //width/height of gallery in pixels. Should reflect dimensions of largest image
	imagearray: [
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_01.jpg"],		
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_02.jpg"],
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_03.jpg"],
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_04.jpg"],
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_05.jpg"],
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_06.jpg"],
		["http://valuvet.com.au/_dev2/wp-content/themes/valuvet_new/images/banner_07.jpg"] //<--no trailing comma after very last image element!
	],
	displaymode: {type:'auto', pause:2500, cycles:0, wraparound:false},
	persist: false, //remember last viewed slide and recall within same session?
	fadeduration: 500, //transition duration (milliseconds)
	descreveal: "ondemand",
	togglerid: ""
})


/**  NOT USED

var mygallery2=new fadeSlideShow({
	wrapperid: "fadeshow2", //ID of blank DIV on page to house Slideshow
	dimensions: [250, 180], //width/height of gallery in pixels. Should reflect dimensions of largest image
	imagearray: [
		["http://i26.tinypic.com/11l7ls0.jpg", "", "", "Nothing beats relaxing next to the pool when the weather is hot."],
		["http://i29.tinypic.com/xp3hns.jpg", "http://en.wikipedia.org/wiki/Cave", "_new", "Some day I'd like to explore these caves!"],
		["http://i30.tinypic.com/531q3n.jpg"],
		["http://i31.tinypic.com/119w28m.jpg", "", "", "What a beautiful scene with everything changing colors."] //<--no trailing comma after very last image element!
	],
	displaymode: {type:'manual', pause:2500, cycles:0, wraparound:false},
	persist: false, //remember last viewed slide and recall within same session?
	fadeduration: 500, //transition duration (milliseconds)
	descreveal: "always",
	togglerid: "fadeshow2toggler"
})

/**/