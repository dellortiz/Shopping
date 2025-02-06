   var imgCode =document.getElementById('imgcode') 
   var botoncaptcha =document.getElementById('reload') 
   if(botoncaptcha){
   botoncaptcha.addEventListener('click',createcode)
}
   function createcode(){
    let url = 'funcs/genera_codigo.php'

    fetch(url)
    .then(response=> response.blob() )
    .then(data=>{  
        if(data){
            imgCode.src = URL.createObjectURL(data) 
        }
    
    })
   }

