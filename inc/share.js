 jQuery( document ).ready( function( d, s, id ) {

    // fb + common
    var js, fjs = d.getElementsByTagName( s )[0];

    if ( jQuery( 'li.scpFacebook' ).length ) {

        js = d.createElement( s ); js.id = id;
        js.src = '//connect.facebook.net/en_US/all.js#xfbml=1';
        fjs.parentNode.insertBefore( js, fjs );

    }
  
    jQuery.getScript( 'http://widgets.digg.com/buttons.js' );
    jQuery.getScript( 'https://apis.google.com/js/plusone.js' );
    jQuery.getScript( 'http://platform.linkedin.com/in.js' );
    jQuery.getScript( 'http://platform.twitter.com/widgets.js' );
    jQuery.getScript( 'http://static.bufferapp.com/js/button.js' );

  }( document, 'script' ) );
