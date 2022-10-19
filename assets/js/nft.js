var mysite = document.location.origin;

import ccABI from '../js/contractABI.json' assert {type: 'json'}

$(document).ready(function(){
    
    var contractAddress = function () {
    var tmp = null;
    $.ajax({
          'async': false,
    	  'url': cnft_ajax_url.ajax_url,
    	  'type': "POST",
    	  'data': {'action':'cnft_get_address_ajax'},
    	  'success':function(address){
    	  	if(address){
    	  	    tmp = address.trim();
    	  	} 
    	  }
      });
        return tmp;
    }();
    
    const ethereumButton = document.querySelector('.enableEthereumButton');
    const showAccount = document.querySelector('.showAccount');
    const nftResultBtn = document.querySelector('.resultNFT');
    
    ethereumButton.addEventListener('click', () => {
        
        nftResultBtn.style.color = "black";
        nftResultBtn.innerHTML = "Please wait...";
        connectWallet();
    });
    
    async function connectWallet() {
        
        if(window.ethereum){

          var provider = window.ethereum;

        }else{

          var provider = new WalletConnectProvider.default({
            //infuraId: "27e484dcd9e3efcfd25a83a78777cdf1",
            rpc: {
              1: "https://cloudflare-eth.com/", // https://ethereumnodes.com/
              5: "https://eth-goerli.g.alchemy.com/v2/jcAHeR8VeZ_dzyzNsHVWAUC9gFCF0_tf",
              137: "https://polygon-rpc.com/", // https://docs.polygon.technology/docs/develop/network-details/network/
            },
            bridge: 'https://bridge.walletconnect.org',
            qrcodeModalOptions: {
              desktopLinks: [
                'ledger',
                'tokenary',
                'wallet',
                'wallet 3',
                'secuX',
                'ambire',
                'wallet3',
                'apolloX',
                'zerion',
                'sequence',
                'punkWallet',
                'kryptoGO',
                'nft',
                'riceWallet',
                'vision',
                'keyring'
              ],
              mobileLinks: [
                "rainbow",
                "metamask",
                "argent",
                "trust",
                "imtoken",
                "pillar",
              ],
            },
          });

        

        }
        //  Enable session (triggers QR Code modal)
        await provider.enable();

        /* From Web3 */  
        const web3 = new Web3(provider);

        //window.w3 = web3
        const accounts = await web3.eth.getAccounts();
        const walletAddress = accounts[0];

        const NFTContract = new web3.eth.Contract(ccABI.abi,contractAddress);
        const NFTBalance = await NFTContract.methods.balanceOf(walletAddress).call();
        
        //  Disable session
        //await provider.disconnect()
        
        /* Ether */
        //const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
        
        // const provider = new ethers.providers.Web3Provider(window.ethereum);
        // const signer = provider.getSigner();
        // const NFTContract = new ethers.Contract(contractAddress,ccABI.abi,signer);
        // const NFTBalance = await NFTContract.balanceOf(walletAddress);
        
        console.log(JSON.parse(NFTBalance));
        console.log(walletAddress);
        
	  	if(NFTBalance>0)
  	    {
          $('#wallet_address').val(walletAddress);
          $('body').trigger('update_checkout');
          //ethereumButton.disabled = true;

          nftResultBtn.style.color = "green";
          nftResultBtn.innerHTML = "CodeClouds NFT Discount applied successfully";

        }else{

          nftResultBtn.style.color = "red";
          nftResultBtn.innerHTML = "Sorry! You must have Codeclouds NFT to claim this discount";

        }         
    }
});