

        <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>        
    </div>
        <script src="<?php echo base_url();?>assets/js/main.js"> </script>
        <script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
            </script>
        <script>
            function fetch(){
                $.ajax({
                url : "<?php echo base_url();?>comments/fetch",
                type : "post",
                data :{
                    post_id : <?php echo $post["id"];?>
                },
                success : function(data){
                    let result = data.replace(/<!--  -->/g, "");
                    data = JSON.parse(result);
                    var commentbody = "";
                    data.forEach(element => {

                        commentbody += "<div class='card bg-primary'>";
                        commentbody += "<div class='card-body text-white id='edit_container'>";
                        commentbody += `<h5>${element["content"]} [by <strong>${element["username"]}</strong>]</h5>`;
                        if("<?php echo $this->session->userdata("user_id");?>" == element["user_id"] || Boolean(<?php echo $this->session->userdata("admin");?>) == true){
                         commentbody += `<a href="#" id = "del" value="${element['comment_id']}" class="btn btn-outline-primary bg-light text-primary">Delete</a>`;  
                          commentbody += `<a href="#" id = "edit" value="${element['comment_id']}" class="btn btn-outline-primary bg-light text-primary">Edit</a>`;  
                         // commentbody += '<form action = "" method = "POST" id="delete_form">';
                         // commentbody += `<input type="hidden" id="delete_post_id" value="${element['post_id']}">`;
                         // commentbody += `<input type="hidden" id="delete_user_id" value="${element['user_id']}">`;
                         // commentbody += `<input type="hidden" id="delete_react_id" value="${element['react_id']}">`;
                         // commentbody += `<input type="hidden" id="delete_comment_id" value="${element['comment_id']}">`;
                         // commentbody += '<button class="btn btn-outline-primary bg-light text-primary" id="delete_comment" type="submit">Delete</button>';
                         // commentbody += '</form>';
                         }
                         commentbody += '</div>';
                         commentbody += '</div>';
                         commentbody += '<br>';

                    });
                   
                   
                    $("#comments").html(commentbody);
                }
                });
            }
            fetch();
            $(document).on("click","#create",function(e){
                e.preventDefault();
                var post_id = $("#create_post_id").attr("value");
                var comment = $("#create_comment").val();
                    $.ajax({
                        url : "<?php echo base_url();?>comments/create",
                        type : "post",
                        data : {
                            post_id : post_id,
                            comment : comment
                        },
                        success : function(data){
                            fetch();
                            let result = data.replace(/<!--  -->/g, "");
                            data = JSON.parse(result);
                            if(data.response == "success"){
                                Command: toastr["success"](data.message)
                                toastr.options = {
                                    "closeButton": true,
                                    "debug": false,
                                    "newestOnTop": false,
                                    "progressBar": true,
                                    "positionClass": "toast-top-right",
                                    "preventDuplicates": false,
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "5000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                }
                            }
                            else{
                                Command: toastr["error"](data.message)
                                toastr.options = {
                                    "closeButton": true,
                                    "debug": false,
                                    "newestOnTop": false,
                                    "progressBar": true,
                                    "positionClass": "toast-top-right",
                                    "preventDuplicates": false,
                                    "onclick": null,
                                    "showDuration": "300",
                                    "hideDuration": "1000",
                                    "timeOut": "5000",
                                    "extendedTimeOut": "1000",
                                    "showEasing": "swing",
                                    "hideEasing": "linear",
                                    "showMethod": "fadeIn",
                                    "hideMethod": "fadeOut"
                                }
                            }
                        },
                        error: function (request, error) {
                            alert("AJAX Call Error: " + error);
                        }
                    });
            
                $("#create_form")[0].reset();	
            });
            $(document).on("click","#del",function(e){
                e.preventDefault();
                var comment_id = $(this).attr("value");
                 if(comment_id == ""){
                      alert("Delete id required");
                 }else{
                   const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger me-3'
            },
            buttonsStyling: false
          })

          swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                url : "<?php echo base_url()?>comments/delete",
                type : "post",
                data : {
                  comment_id : comment_id
                },
                success : function(data){
                  fetch();
                  let result = data.replace(/<!--  -->/g, "");
                  data = JSON.parse(result);
                  console.log(data);
                  if(data.response == "success"){
                    swalWithBootstrapButtons.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                   )
                  }
                }
              });
            } else if (
              /* Read more about handling dismissals below */
              result.dismiss === Swal.DismissReason.cancel
            ) {
              swalWithBootstrapButtons.fire(
                'Cancelled',
                'Your imaginary file is safe :)',
                'error'
              )
            }
          })
        }
      });
      $(document).on("click","#edit",function(e){
        e.preventDefault();
        var edit_id = $(this).attr("value");
        if(edit_id == ""){
          alert("Edit id is required");
        }else{
          $.ajax({
            url : "<?php echo base_url()?>comments/edit",
            type : "post",
            data : {
              edit_id : edit_id
            },
            success : function(data){
              fetch();
              let result = data.replace(/<!--  -->/g, "");
              data = JSON.parse(result);
              console.log(data);
              if(data.response == "success"){
                $("#edit").replaceWith("<div> asdas </div>");
              }
              // else{
              //     Command: toastr["error"](data.message)
              //     toastr.options = {
              //     "closeButton": true,
              //     "debug": false,
              //     "newestOnTop": false,
              //     "progressBar": true,
              //     "positionClass": "toast-top-right",
              //     "preventDuplicates": false,
              //     "onclick": null,
              //     "showDuration": "300",
              //     "hideDuration": "1000",
              //     "timeOut": "5000",
              //     "extendedTimeOut": "1000",
              //     "showEasing": "swing",
              //     "hideEasing": "linear",
              //     "showMethod": "fadeIn",
              //     "hideMethod": "fadeOut"
              //   }
              // }
            }

          });
        }
      });
        </script>
    </body>
</html>