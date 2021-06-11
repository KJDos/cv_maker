
var addSkillBtn = document.querySelector('.js-add-skill')

addSkillBtn.addEventListener("click", function(){
    const index = document.querySelector('#widgets-counter').value;

    const templateFormSkill = document.querySelector('[data-prototype]').dataset.prototype.replace(/__name__/g, index);
    
    document.querySelector('#curriculum_skills').innerHTML += templateFormSkill
    document.querySelector('#widgets-counter').value ++
    deleteSkill();

})

function deleteSkill(){
    var deleteSkillBtn = document.querySelectorAll('.js-delete-skill');

    for (let i = 0; i < deleteSkillBtn.length; i++) {
        deleteSkillBtn[i].addEventListener("click", function(){
            //console.log(deleteSkillBtn[i].dataset.target)
            document.querySelector(deleteSkillBtn[i].dataset.target).remove();
        })

    }
}

deleteSkill();

