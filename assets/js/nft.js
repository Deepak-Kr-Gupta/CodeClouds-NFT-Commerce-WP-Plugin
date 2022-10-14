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
        
        if(window.ethereum){
            getAccount();
          }else{
            nftResultBtn.style.color = "red";
            nftResultBtn.innerHTML = "You have no NFT wallet to connect. Please install one and continue!";
        }
      
    });
    
    async function getAccount() {
        
        //console.log('works');
        
      /* From Web3 */  
        //const web3 = new Web3(window.ethereum);
        
        const accounts = await ethereum.request({ method: 'eth_requestAccounts' });
        //const accounts = await web3.eth.getAccounts();
        const walletAddress = accounts[0];

        //const NFTContract = new web3.eth.Contract(ccABI.abi,contractAddress);
        
        //const NFTBalance = await NFTContract.methods.balanceOf(walletAddress).call();
        
        /* Ether */
        
        const provider = new ethers.providers.Web3Provider(window.ethereum);
        const signer = provider.getSigner();
        const NFTContract = new ethers.Contract(contractAddress,ccABI.abi,signer);
        const NFTBalance = await NFTContract.balanceOf(walletAddress);
        
        console.log(JSON.parse(NFTBalance));
        console.log(walletAddress);
        
        
	  	if(NFTBalance>0)
  	    {
  
          $('#wallet_address').val(walletAddress);
          $('body').trigger('update_checkout');

          nftResultBtn.style.color = "green";
          nftResultBtn.innerHTML = "Codeclouds NFT Discount applied successfully";
          
        }else{
          nftResultBtn.style.color = "red";
          nftResultBtn.innerHTML = "Sorry! You must have Codeclouds NFT to claim this discount";
    
        }
        
      /* From Web3 */  
         
    }
});


