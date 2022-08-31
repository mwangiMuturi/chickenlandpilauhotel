
const submit=document.getElementById('button');
submit.addEventListener('click', validate);
function validate(){
//alert('yooj')
//alert ('ayela')
let errors=[];
let price=document.getElementById('price').value;
let title=document.getElementById('title').value;
if(price==""){
    errors.push('Enter price')

}else if (title=""){
    errors.push('Enter title')
}
if(errors[1]=='Enter Price'){
   // alert('error')
}
console.log(errors)
}
