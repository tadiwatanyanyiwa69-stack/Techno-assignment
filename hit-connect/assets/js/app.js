document.addEventListener('DOMContentLoaded',()=> {
  document.querySelectorAll('[data-confirm]').forEach(el=>{
    el.addEventListener('click',e=>{
      if(!confirm(el.dataset.confirm)){e.preventDefault();}
    });
  });
  const fileInputs=document.querySelectorAll('input[type=file][data-preview]');
  fileInputs.forEach(input=>{
    input.addEventListener('change',()=>{
      const img=document.querySelector(input.dataset.preview);
      const file=input.files?.[0];
      if(img && file) img.src=URL.createObjectURL(file);
    });
  });
});