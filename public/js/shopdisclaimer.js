$(document).ready(function(){  

  $('textarea[name="shopdisclaimer"').val($('#disclaimer').val());
  $('#shopdisclaimer_form').bootstrapValidator({

         feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },

        fields: {
          shopdisclaimer: {
            enabled: true,
            validators: {
              notEmpty: {
                  message: 'The shop disclaimer is required and cannot be empty'
              },
              stringLength: {
                max: 800,
                message: 'please enter valid input maxmimun 800 numbers'
              },            
            }
          }
        }


     });

});
