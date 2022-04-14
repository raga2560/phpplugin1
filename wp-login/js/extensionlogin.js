




async function extensionlogin () {
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


