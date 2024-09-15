<div class="my-5 pt-4">
    <div class="container">
        <div class="col-12">
            <div class="row mx-0 d-flex justify-content-cente mb-2">
                <div class="col-12">
                <div class="input-group mb-3">
                    <input type="text" id="search" class="form-control rounded-0" placeholder="Search Here" aria-label="Search Here" aria-describedby="basic-addon2" autocomplete="off">
                    <span class="input-group-text" id="basic-addon2"><i class="fa fa-search"></i></span>
                </div>
                </div>
            </div>
            <div class="row mx-0 row-cols-1 row-cols-sm-1 row-cols-xl-3 gx-5 gy-3" id="vacancy_list">
                <?php
                $sql = "SELECT * FROM category_list order by `name` asc";
                $qry = $conn->query($sql);
                $i = 0;
                while($row = $qry->fetchArray()):
                ?>
                <div class="item col wow bounceInUp" data-wow-delay="<?php echo ($i > 0) ? $i:''; $i += .5; ?>s">
                    <div class="card shadow-sm ">
                        <div class="card-body ">
                            <h5 class="card-title mb-1"><?php echo $row['name'] ?></h5>
                            <hr class="bg-primary opacity-100">
                            <p class="truncate-3 fw-light fst-italic lh-1" title="<?php echo $row['description'] ?>"><small><?php echo $row['description'] ?></small></p>
                            <div class="w-100 d-flex justify-content-end">
                                <div class="col-auto">
                                    <a href="./?page=recipe&cid=<?php echo $row['category_id'] ?>" class="btn btn-sm btn-primary bg-gradient rounded-0 py-0">Explore Recipes</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>

            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('#search').on('input',function(){
            var _search = $(this).val().toLowerCase()
            $('#vacancy_list .item').each(function(){
                var _text = $(this).text().toLowerCase()
                if(_text.includes(_search) == true){
                    $(this).toggle(true)
                }else{
                    $(this).toggle(false)
                }
            })
        })
    })
</script>