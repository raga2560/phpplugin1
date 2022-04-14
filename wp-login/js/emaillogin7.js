

 function loginQuery(user, pass) {
 	
    jQuery.ajax({
           type:"POST",
           url: my_ajax_object.ajax_url,
           data: {
               action: "login_action",
               user: user, 
               pass : pass,
           },
           success:function(data){
               if(data.indexOf('Success')!=-1){
                 //window.location.reload();
				  jQuery('#message').html("<?php _e('Login success'); ?>");
               }
           },
		   error: function(msg) {  
                // login error.                 
                
                jQuery('#message').html("<?php _e('Your login  is not correct. Please try again.'); ?>");
                
            }
    });
  }

 

function emaillogin () {
	console.log(my_ajax_object.ajax_url);
	alert(my_ajax_object.ajax_url);
	var loginsuccess = true;
	
	var email = document.getElementById('txtUser').value;
    var pass = document.getElementById('txtPass').value;
	
    if(loginsuccess) {
	//   loginQuery(email, pass);
	   jQuery('#message').html("<?php _e('Login success'); ?>");
	}else {
	    jQuery('#message').html("<?php _e('Your login  is not correct. Please try again.'); ?>");
	}
	
}

async function emaillogin1 () {
  const provider = new WsProvider('wss://student.selendra.org');

  // Create the API and wait until ready
  const api = await ApiPromise.create({ provider });


const keyring = new Keyring({ type: 'sr25519' });

  // Add Alice to our keyring with a hard-deived path (empty phrase, so uses dev)
  const meo = keyring.addFromUri(masteruri);

  let alice = keyring.addFromUri(uriofid);



  const { nonce } = await api.query.system.account(meo.address);

  let record = await api.query.identity.studentidOf(email);

  if(record.inspect().inner) {
    let recordp = JSON.parse(record);
    console.log("Email " + email + " registered with " + recordp.accountId);
    console.log(JSON.stringify(recordp));

  }else {
    console.log("Email "+ email + "  not registered" );
    alert(" email  not registered");
  }

 let recordp = JSON.parse(record);

  if(alice.address == recordp.accountId) {
    console.log("Valid mneomonic allow login");
    alert("valid address");

  }else {
    console.log("Invalid mneomonic provided");
    alert("invalid mneomonic");
  }

}


