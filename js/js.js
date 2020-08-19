function errorConnect(){
    $('.erreurConnect').removeAttr('hidden');
};

function inviteConnect(){
    $('.saisie').attr('hidden', true);
};

function afficheSuccessInsert(){
    $('#insertsuccess').removeAttr('hidden');
};

$(function(){
    $('#tonnageForm').submit(function(e) {
        e.preventDefault();

        $.post(
            './ajax.php',
            {
                dechetterie: $('#dechetterie').val(),
                date: $('#time').val()
            },

            function(data){

                if (data != 0)
                {
                    $('.tableau').html(data);
                    $('.alert-dechet').attr('hidden', 'true');
                }
                else
                {
                    $('.tableau').html('');
                    $('.alert-dechet').removeAttr('hidden');
                }
            },
        ); 
    });

    $('#connexionForm').submit(function(e){
        e.preventDefault();

        $.post(
            './ajax.php',
            {
                login: $('#login').val(),
                password: $('#password').val()
            },

            function(data){
                if(data == 'erreur')
                {
                    errorConnect();
                }
                else
                {
                    window.location.href = './accueil.php';
                }
            }
        );
    });

});