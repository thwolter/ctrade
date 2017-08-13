/* ========================================================
*
* MVP Ready - Lightweight & Responsive Admin Template
*
* ========================================================
*
* File: mvpready-launch.js
* Theme Version: 3.0.0
* Bootstrap Version: 3.3.6
* Author: Jumpstart Themes
* Website: http://mvpready.com
*
* ======================================================== */

var mvpready_launch = function () {

  "use strict"

  var initVegasBg = function () {
    $.vegas ({
      src:'/img/home/portfolio.jpg'
      , fade: 2000
    })

    $.vegas ('overlay', {
      //src:'/img/launch/13.png'
    })
  }

  var initCountdown = function () {
    var target = new Date (2017,9,31)

    $('.countdown').downCount ({
      date: target
    })
  }

  return {
    init: function () {
      mvpready_core.initNavHover ({ delay: { show: 250, hide: 350 } })

      initVegasBg ()
      initCountdown ()
      mvpready_helpers.initTooltips ()
    }
  }

} ()

$(function () {
  mvpready_launch.init ()
})

$(window).load (function () {
  $('.mask').fadeOut ('fast', function ()  { $(this).remove () } )
})