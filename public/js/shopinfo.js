$(document).ready(function(){  
  $('#shopinfo_form').bootstrapValidator({

         feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },

        fields: {
          street: {
            enabled: true,
            validators: {
              notEmpty: {
                  message: 'The street is required and cannot be empty'
              }            
            }
          },
          city: {
            enabled: true,
            validators: {
              notEmpty: {
                  message: 'The city is required and cannot be empty'
              }            
            }
          },
          province: {
            enabled: true,
            validators: {
              notEmpty: {
                  message: 'The province is required and cannot be empty'
              }            
            }
          },
          postal_code: {
            enabled: true,
            validators: {
              notEmpty: {
                  message: 'The postal code is required and cannot be empty'
              } ,
              integer: {
                message: 'Please input valid postal code'
              }           
            }
          },
          phone_number: {
            enabled: true,
            validators: {
              notEmpty: {
                  message: 'The phone number is required and cannot be empty'
              },
              regexp: {
                  regexp: /\(?([0-9]{3})\)?([ ]?)([0-9]{3})?([ -]?)\2([0-9]{4})/,
                  message: 'Please input valid phone number'
              }           
            }
          }
        }


     });

});
