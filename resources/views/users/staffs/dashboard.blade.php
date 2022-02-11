@extends('users.staffs.layout.app')
@section('title', 'Staff Dashboard')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>
    <h1>Steganalysis</h1>

    <div class="section-body">
        <h2 class="section-title">{{ ucwords(Auth::user()->name) }}</h2>
        {{--  <p class="section-lead">Change information about yourself on this page.</p>  --}}

        <div class="row mt-sm-4">
            {{--  <div class="col-12 col-md-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Encryption</h4>
                    </div>
                    <div class="card-body">
                        <form id="encryptAES" method="post">
                            <div class="form-group">
                                <label for="comment">Message:</label>
                                <textarea name="message" class="form-control  @error('message') is-invalid @enderror" rows="5" id="comment">
                                    {{ old('message') }}
                                </textarea>
                                @error('message')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>


                        <div class="form-group">
                            <label for="usr">Your Private Key:</label>
                            <input type="password" value="{{ old('private') }}" name="private" class="form-control   @error('private') is-invalid @enderror" id="usr">
                            @error('private')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                         {{ csrf_field() }}


                        <button type="submit" class="btn btn-warning">Encrypt With AES</button>
                    </form>
                    <form id="generateStego" method="post" enctype="multipart/form-data">


                        <div class="form-group">
                            <label for="comment">Encrypted Message:</label>
                            <textarea id="encrypedmessage" class="form-control  @error('encrypedmessage') is-invalid @enderror" rows="5" name="encrypedmessage" id="comment">
                                  {{old('encrypedmessage') }}
                            </textarea>
                            @csrf
                            @error('encrypedmessage')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                             @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Choose Cover Image</label>
                            <input type="file" id="coverimage" name="coverimage" class="form-control-file border  @error('coverimage') is-invalid @enderror" name="file">
                            @error('coverimage')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-radio">
                            <label class="form-radio-label" for="check1">
                              <input type="radio" class="form-radio-input" id="check1" name="encryptionalgorithm" value="pvd" checked>PVD
                            </label>
                          </div>
                          <div class="form-radio">
                            <label class="form-check-label" for="check2">
                              <input type="radio" class="form-radio-input" id="check2" name="encryptionalgorithm" value="lsb">LSB
                            </label>
                          </div>
                    </div>

                        <div class="row" id="imageinfo" style="display: none">
                            <div class="col">
                                <img id="imageinf" src="{{ asset('assets/fonts/images/img_avatar3.png') }}" style="width: 200px" class="card-img" alt="">
                            </div>
                            <div class="col">
                                <h6>Image Information</h6>
                                <p>Width: <b id="coverImgWidth"></b></p>
                                <p>Height: <b id="coverImgHeight"></b></p>
                                <p>Payload: <b>200</b></p>
                            </div>
                        </div>

                        <div id="generatedStedImage">

                        </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">Embed Now</button>
                    </div>
                </form>
                </div>
            </div>  --}}
            <div class="col-12 col-md-12 col-lg-6">
                <div class="card">
                        <div class="card-header">
                            <h4>Check For stego Image</h4>
                        </div>
                        <div class="card-body">
                            <form id="decryptStegoImage" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="">Choose Stego Image</label>
                                <input name="stegoimage" id="stegoimage" type="file" class="form-control-file border  @error('stegoimage') is-invalid @enderror">
                                @error('stegoimage')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>


                            {{--  <h4 class="stegostatusyes text-success"></h4>  --}}
                            {{--  <h4 class="stegostatusyes text-danger"></h4>  --}}
                            <h4 id="stegoimageinfo"></h4>
                            <input type="hidden" name="status" value="check" id="status">
                        </div>
                        <div class="card-footer text-right">
                            <input type="submit" name="checkstego" id="checkstego" value="Check Stego" class="btn btn-info">
                            {{--  <input type="submit" name="decryptstego" class="btn btn-warning" value="Decrypt message carried">
                            <input type="submit"  name="destroystego" class="btn btn-danger" value="Destroy message carried">  --}}

                        </div>
                    </form>
                </div>

                {{--  <div class="row" id="stegoimageinfo" style="display: none">  --}}

                    <div class="col-6">
                        <img id="stegoimageinf" src="{{ asset('assets/fonts/images/img_avatar3.png') }}" style="width: 200px" class="card-img" alt="">
                    </div>
                     <div class="col-6">
                        <img id="stegoimagedestroyed" class="card-img" >
                        <p><a href="" download id="downloaddestroyed"></a>
                        </p>
                    </div>
                    {{--  <span id="notstego"></span>
                    <span id="invalidekey"></span>  --}}


                    {{--  <div class="col-12" style="width: min-content">
                        <span id="ciphertextfromstego"></span>
                    </div>
                    <div class="col-6">
                        <h6 id="plaintextfromstego"></h6>
                    </div>  --}}
                </div>



            </div>
        </div>
    </div>

</section>
@endsection
@section('script')
<script>
$(document).ready(function() {

    $("#coverimage").change(function () {
            previewpassport(this, "imageinf",'coverImgHeight', 'coverImgWidth', 'imageinfo');


        });


        $("#stegoimage").change(function () {
            previewpassport(this, "stegoimageinf",'stegoImgHeight', 'stegoImgWidth', 'stegoimageinfo');


        });

        $('#encryptAES').submit(function(e) {
            e.preventDefault();
            var datas = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('encryptAES') }}",
                data: datas,
                contentType: false,
                // dataType : 'json',
                cache: false,
                processData: false,
                success: function(data) {
                    // console.log(data);
                    $("#encrypedmessage").text(data);

                },
                error:function(err){
                    if(err.status ==422){
                        console.log(err.status);
                        $.each(err.responseJSON.errors, function(i, error){
                            var el = $(document).find('[name="'+i+'"]');
                            el.after($('<span style="color:red">'+ error[0] +'</span>'))
                        })
                    }
                }

            })
        })


        $('#generateStego').submit(function(e) {
            e.preventDefault();
            var datas = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('embed-with-stego') }}",
                data: datas,
                contentType: false,
                // dataType : 'json',
                cache: false,
                processData: false,
                success: function(data) {
                    // console.log(data);
                    $("#generatedStedImage").html(data);

                },
                error:function(err){
                    if(err.status ==422){
                        console.log(err.status);
                        $.each(err.responseJSON.errors, function(i, error){
                            var el = $(document).find('[name="'+i+'"]');
                            el.after($('<span style="color:red">'+ error[0] +'</span>'))
                        })
                    }
                }

            })
        })


        $('#decryptStegoImage').submit(function(e) {
            e.preventDefault();
            var datas = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ route('decrypt') }}",
                data: datas,
                contentType: false,
                dataType : 'json',
                cache: false,
                processData: false,
                success: function(data) {

                   if(data.plain){
                        // alert(data.plain)
                        $("#stegoimageinfo").removeClass();
                        $("#stegoimageinfo").addClass('text-danger').text(data.plain);
                        $("#status").val("destroy");
                        $("#checkstego").removeAttr('class');
                        $("#checkstego").val("Destroy Stego").addClass('btn btn-danger');

                    }
                    if(data.check){
                        $("#stegoimageinfo").removeAttr('class');
                        $("#stegoimageinfo").addClass('text-info').text(data.check);
                        $("#status").val("decode");
                        $("#checkstego").removeAttr('class');
                        $("#checkstego").val("Decode Stego").addClass('btn btn-warning');

                    }
                    if(data.destroy){
                        $("#stegoimageinfo").removeAttr('class');
                        $("#stegoimageinfo").addClass('text-info').text(data.msg);
                        $("#stegoimagedestroyed").attr('src', data.destroy);
                        $("#status").val("check");
                        $("#downloaddestroyed").attr('href', data.destroy).text('Download Destroy Now');

                        $("#checkstego").removeAttr('class');
                        $("#checkstego").remove();

                    }


                },
                error:function(err){
                    if(err.status ==500){
                        $("#stegoimageinfo").addClass('text-danger').html("<h4 class='text-danger'>Not Stego Image, Please Request for Another Image From Sender</h4>");
                    }
                    if(err.status ==422){
                        console.log(err.status);
                        $.each(err.responseJSON.errors, function(i, error){
                            var el = $(document).find('[name="'+i+'"]');
                            el.after($('<span style="color:red">'+ error[0] +'</span>'))
                        })
                    }
                }

            })
        })



    function previewpassport(input, data, h, w, display) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    // $('#uppreviewimage + img').remove();
                    // console.log(e);
                    $('#'+data).attr('src', e.target.result);
                    var img = new Image();
                    img.src = e.target.result;
                    img.onload = function(){
                        // console.log(this.width);
                        $("#"+w).text(this.width)
                        $("#"+h).text(this.height)
                        $("#"+display).removeAttr('style')
                        $("#status").val("check");
                        $("#checkstego").removeAttr('class');
                        $("#checkstego").val("Check Stego Status").addClass('btn btn-info');

                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
        }


    })
</script>
@endsection


