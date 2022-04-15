<?php
/**
 * Plugin Name: Wordpress Login
 * Description: This is an example WP Login
 * Version: 1.0.1
 * Author: Srirajan
 * Author URI:
 * License: GPL
 */
 add_action( 'my_login', 'my_login' );

 add_shortcode( 'my_login', 'my_login' );




 function my_login_plugin_scripts() {
     wp_enqueue_script( 'jquery', plugin_dir_url( __FILE__ ) . '/js/jquery-3.6.0.min.js', array( 'jquery' ), '1.0.0', true );
     wp_enqueue_script( 'mylogin', plugin_dir_url( __FILE__ ) . '/js/mylogin.js' );
	 wp_enqueue_script( 'mytest', plugin_dir_url( __FILE__ ) . '/js/mytest.js' );
	 wp_enqueue_script( 'mnemoniclogin10', plugin_dir_url( __FILE__ ) . '/js/mnemoniclogin10.js', "", null );
	 wp_enqueue_script( 'extensionlogin', plugin_dir_url( __FILE__ ) . '/js/extensionlogin.js', "", null );
	 wp_enqueue_script( 'emaillogin17', plugin_dir_url( __FILE__ ) . '/js/emaillogin17.js', "", null );
     wp_localize_script( 'mylogin', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

     wp_register_script('prefix_bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js');
     wp_enqueue_script('prefix_bootstrap');
     wp_register_style('prefix_bootstrap', '//cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css');
     wp_enqueue_style('prefix_bootstrap');
 }
 add_action( 'wp_enqueue_scripts', 'my_login_plugin_scripts' );

 add_action( 'wp_ajax_login_action', 'login_action' );
 add_action( 'wp_ajax_nopriv_login_action', 'login_action' );

 function login_action(){
   //echo $_REQUEST['user']." : ".$_REQUEST['pass'];
   //$user = get_user_by('login', $_REQUEST['user'] );
   if ( $user = get_user_by('login', $_REQUEST['user'] ) )
   {
	 if ( $_REQUEST['decision'] == 'true' ) {
     wp_clear_auth_cookie();
     wp_set_current_user ( $user->ID );
     wp_set_auth_cookie  ( $user->ID );
     echo "Success";
	 }
   } 
   else if ( $_REQUEST['create'] == 'yes'){
	    
     $userdata = array(
        'user_login' =>  $_REQUEST['user'],
        'user_email' =>  $_REQUEST['user'],
        'user_pass'  =>  wp_hash_password( $_REQUEST['pass'] ) // When creating an user, `user_pass` is expected.
     );

     $user_id = wp_insert_user( $userdata ) ;

     $user = get_user_by('login', $_REQUEST['user']);
	 if ( $_REQUEST['decision'] == 'true' ) {
     wp_clear_auth_cookie();
     wp_set_current_user ( $user->ID );
     wp_set_auth_cookie  ( $user->ID );

	 echo "Success"; 
	 }
   } 
   
 }
 
 
 




 function my_login ( $content ) {
   if(!is_user_logged_in()){
?>

<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-util.js?ver=5.9.3' id='polkadotUtil-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-util-crypto.js?ver=5.9.3' id='polkadotUtilCrypto-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-keyring.js?ver=5.9.3' id='polkadotKeyring-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-types.js?ver=5.9.3' id='polkadotTypes-js'></script>
<script src='https://wordpress.koompi.org/wp-content/plugins/wp-login/js/bundle-polkadot-api.js?ver=5.9.3' id='polkadotApi-js'></script>

<script>

const { bnToBn, u8aToHex } = polkadotUtil;
const { blake2AsHex, randomAsHex, selectableNetworks } = polkadotUtilCrypto;
const { Keyring } = polkadotKeyring;
const { cryptoWaitReady } = polkadotUtilCrypto;
const { ApiPromise, WsProvider } = polkadotApi; //require('@polkadot/api');
//const { Keyring } = require('@polkadot/keyring');
const { randomAsU8a, randomAsNumber } = polkadotUtilCrypto; // require( '@polkadot/util-crypto');
const { stringToU8a } = polkadotUtil;
</script>

      <div class="container">
          <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
              <div class="panel panel-info" >
                      <div class="panel-heading">
                          <div class="panel-title">Email login</div>
                          <div style="float:right; font-size: 80%; position: relative; top:-10px"><a href="#">Forgot password?</a></div>
                      </div>

                      <div style="padding-top:30px" class="panel-body" >

                          <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            <form id="emailloginform" class="form-horizontal" role="form">
                                <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                  <input id="txtUser" name="txtUser" type="email" class="form-control" name="username" value="" placeholder="Email">
                                </div>

                                <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                  <input id="txtPass" name="txtPass" type="password" class="form-control" name="password" placeholder="Password">
                                </div>

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->
                                    <div class="col-sm-12 controls">
                                      
                                      
									  
									  <a id="emailtxtSubmit" name="emailtxtSubmit" onclick="emaillogin();" class="btn btn-success">Login  </a>
                                    </div>
                                </div>
								<div id="message" name="message">
								
								</div>
								
                            </form>
                          </div>
                      </div>
          </div>
      </div>
	  <div class="container">
          <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
              <div class="panel panel-info" >
                      <div class="panel-heading">
                          <div class="panel-title">Mnemonic login</div>
                          
                      </div>

                      <div style="padding-top:30px" class="panel-body" >

                          <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            <form id="mneloginform" class="form-horizontal" role="form">
                                <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                  <input id="Publickey" name="Publickey" type="text" class="form-control" name="Publickey" value="" placeholder="Publickey">
                                </div>

                                <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                  <input id="txtMnemonic" name="txtMnemonic" type="text" class="form-control" name="Mnemonic" value="" placeholder="Mnemonic">
                                </div>

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->
                                    <div class="col-sm-12 controls">
                                                                           
									  
									  <a id="mneSubmit" name="mnetxtSubmit" onclick="menomoniclogin();" class="btn btn-success">Login  </a>
                                    </div>
                                </div>
								<div id="mnemessage" name="mnemessage">
								
								</div>
                            </form>
                          </div>
                      </div>
          </div>
      </div>
	  
	   <div class="container">
          <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
              <div class="panel panel-info" >
                      <div class="panel-heading">
                          <div class="panel-title">Extension login</div>
                          
                      </div>

                      <div style="padding-top:30px" class="panel-body" >

                          <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            <form id="extloginform" class="form-horizontal" role="form">
                                <div style="margin-bottom: 25px" class="input-group">
                                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                  <input id="extPublickey" name="extPublickey" type="text" class="form-control" name="extPublickey" value="" placeholder="External Publickey">
                                </div>

                                

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->
                                    <div class="col-sm-12 controls">
                                                                           
									  
									  <a id="extsubmit" name="exttxtSubmit" onclick="extpubsubmitClick();" class="btn btn-success">Login  </a>
									  
                                    </div>
                                </div>
                            </form>
                          </div>
                      </div>
          </div>
      </div>
	  
	  
<?php
    }
    else{
?>
        <center>Click <a href="<?php echo wp_logout_url();?>">here</a> to logout</center>
<?php
    }
 }
