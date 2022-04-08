 <!-- Header-->
 <header class="bg-dark py-5" id="main-header">
    <div class="container h-100 d-flex align-items-center justify-content-center w-100">
        <div class="text-center text-white w-100">
            <h1 class="display-4 fw-bolder">Available Cabs</h1>

        </div>
    </div>
</header>
<!-- Section-->
<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                <div class="input-group mb-3">
                    <input type="search" id="search" class="form-control" placeholder="Search Here" aria-label="Search Here" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <span class="input-group-text bg-info" id="basic-addon2"><i class="fa fa-search"></i></span>
                    </div>
                </div>
                </div>
                <div class="row  row-cols-1 row-cols-sm-1 row-cols-md-2 row-cols-xl-2" id="cab_list">

                    <?php
                    $cabs = $conn->query("SELECT c.*, cc.name as category FROM `cab_list` c inner join category_list cc on c.category_id = cc.id where c.delete_flag = 0 and c.id not in (SELECT cab_id FROM `booking_list` where `status` in (0,1,2)) order by c.`reg_code`");
                    while($row= $cabs->fetch_assoc()):
                    ?>
                    <a class="col item text-decoration-none text-dark book_cab" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>" data-bodyno="<?php echo $row['body_no'] ?>">
                    <div class="card" style="width: 18rem;">
                    <img src="uploads/cars.jpg" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">Card title</h5>
                        <p class="card-text"><?php echo $row['category'] ?></p>
                        <small> <?php echo $row['body_no'] ?> </small>
                        <small><?php echo $row['cab_model'] ?></small>
                    </div>
                    </div>


                    </a>
                    <?php endwhile; ?>

                </div>
                <div id="noResult" style="display:none" class="text-center"><b>No Result</b></div>
            </div>
        </div>
    </div>
</section>
<script>
    $(function(){
        $('#search').on('input',function(){
            var _search = $(this).val().toLowerCase().trim()
            $('#cab_list .item').each(function(){
                var _text = $(this).text().toLowerCase().trim()
                    _text = _text.replace(/\s+/g,' ')
                    console.log(_text)
                if((_text).includes(_search) == true){
                    $(this).toggle(true)
                }else{
                    $(this).toggle(false)
                }
            })
            if( $('#cab_list .item:visible').length > 0){
                $('#noResult').hide('slow')
            }else{
                $('#noResult').show('slow')
            }
        })
        $('#cab_list .item').hover(function(){
            $(this).find('.callout').addClass('shadow')
        })
        $('#cab_list .book_cab').click(function(){
            if("<?= $_settings->userdata('id') && $_settings->userdata('login_type') == 2 ?>" == 1)
                uni_modal("Book Cab - "+$(this).attr('data-bodyno'),"booking.php?cid="+$(this).attr('data-id'),'mid-large');
            else
            location.href = './login.php';
        })
        $('#send_request').click(function(){
            if("<?= $_settings->userdata('id') > 0 && $_settings->userdata('login_type') == 2 ?>" == 1)
            uni_modal("Fill the cab Request Form","send_request.php",'mid-large');
            else
            alert_toast(" Please Login First.","warning");
        })

    })
    $(document).scroll(function() {
        $('#topNavBar').removeClass('bg-transparent navbar-dark bg-primary')
        if($(window).scrollTop() === 0) {
           $('#topNavBar').addClass('navbar-dark bg-transparent')
        }else{
           $('#topNavBar').addClass('navbar-dark bg-primary')
        }
    });
    $(function(){
        $(document).trigger('scroll')
    })
</script>