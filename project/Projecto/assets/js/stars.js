
function getStarsValue(form){
    
    var numb = 6;

    var ele = document.getElementsByName('rating');
    var isRated = false;
     for(i = 0; i < ele.length; i++) {
                if(ele[i].checked){
                    isRated = true;
                    numb = i;
                    document.getElementsByName('starValue')[0].value =  numb;
                    
                    
                    
                }
               
        }
        if (isRated === false){
            alert("Comments must have a rating")
            form.commentText.focus();
            return false;
        }

}
