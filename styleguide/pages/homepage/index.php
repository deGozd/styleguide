<!-- Include Header -->
<?php include 'system/header.php';

    $i = 0; 
    $dir = 'uploads/';
    if ($handle = opendir($dir)) {
        while (($file = readdir($handle)) !== false){
            if (!in_array($file, array('.', '..')) && !is_dir($dir.$file)) 
                $i++;
        }
    }

    $a = $i - 1;

    if ($a === 0) {
    ?>


<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>

<?php
    } else {

?>

<!-- General Navigation -->
<div class="nav">
    <ul>
        <li>New Page</li>
        <li><a href="fonts.php">Font Book</a></li>
        <li><a href="swatches.php">Swatches</a></li>
        <li>Style Guide</li>
    </ul>
</div>
<div id="menu">
    <button class="menu"><i class="fa fa-bars"></i></button>
</div>

<!-- Create Canvas -->
<div class="canvas">
    <img src="uploads/product.png">
</div>

<!-- Begin Style Guide Toolbar -->    
<div class='sg-container' class="ui-widget-content">
    <!-- Style Guide Toolbar Drag -->
    <div class='sg-grabber'>
        <div class="dots">
            <i class="fa fa-circle"></i>
            <i class="fa fa-circle"></i>
            <i class="fa fa-circle"></i>
        </div>
        <div class="functions">
            <a class="close">
                <i class="fa fa-remove"></i>
            </a>
        </div>
        <div class="clear"></div>
    </div>
    <!-- Style Guide Toolbar Content -->
    <div class="sg-box">
        <div class="sg-text-box sg-hide">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <!-- Style Guide Toolbar Title Input -->
                <div class='sg-header'>
                    <input name="styletitle" type="text" placeholder="New Font Style" required style="border:none">
                    <a class='helper'>&#63;</a>
                    <a class='defaults'><i class='fa fa-list'></i></a>
                    <div class="clear"></div>
                </div>
                <!-- Style Guide Toolbar Colour Input -->
                <input type='color' name="stylecolour" class="sg-colour-input">
                <!-- Style Guide Toolbar Font Style -->
                <div class="sg-text-details">
                    <!-- Font Style Font Family -->
                    <div class="sg-font-family sg-block">
                    <label>Font</label>
                        <i class="fa fa-caret-down"></i>
                        <select name="font">
                            <?php
                            $sql = "SELECT font FROM fonts";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo '<option value="' . $row["font"] . '">' . $row["font"] . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Font Style Font Size -->
                    <div class="sg-font-size sg-block">
                        <label>Font Size</label>
                        <input type="number" required name="fontsize"><span>px</span>
                    </div>
                    <!-- Font Style Font Colour -->
                    <div class="sg-font-colour sg-block">
                        <label>Font Colour</label>
                        <i class="fa fa-caret-down"></i>
                        <select name="fontcolour">
                            <?php 
                            $sql = "SELECT id, swatch FROM swatches";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo '<option>#' . $row["swatch"] . '<span class="swatch-preview" style="background:' . $row["swatch"] . '"></span></option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Clear -->
                    <div class="clear"></div>
                    <!-- Font Style Additional Information -->
                    <div class="sg-additional-info sg-block">
                        <label>Additional Information</label>
                        <textarea name="additional"></textarea>
                    </div>
                </div>
                <!-- Style Guide Save -->
                <div class="sg-options">
                    <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if(isset($_POST["saved"])) {
                            $sql = "SELECT styletitle FROM pagetitle";
                            $result = $conn->query($sql);
                            $insert = true; 
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while($row = $result->fetch_assoc()) {     
                                    if ($_POST["styletitle"] === $row["styletitle"] ) {
                                        $insert = false;
                                    } 
                                }
                            }   
                            if ($insert) {
                                $sql = "INSERT INTO pagetitle (x, y, styletitle, font, fontsize, fontcolour, additional, stylecolour) VALUES ('" . $_POST["x"] . "', '" . $_POST["y"] . "', '" . $_POST["styletitle"] . "', '" . $_POST["font"] . "', '" . $_POST["fontsize"] . "', '" . $_POST["fontcolour"] . "', '" . $_POST["additional"] . "', '" . $_POST["stylecolour"] . "')";
                                if ($conn->query($sql) !== TRUE) {
                                    echo "Error creating record: " . $conn->error;
                                }   
                            }
                        }
                        if(isset($_POST["removed"])) {
                            $sql = 'DELETE FROM pagetitle WHERE id=' . $_POST["remove"];
                            if ($conn->query($sql) === TRUE) {
                            } else {
                                echo "Error deleting record: " . $conn->error;
                            }
                        }
                    }
                    ?>
                    <input type="submit" name="saved" class="sg-save">
                    <!-- Style Guide Dot Coordinates -->
                    <input class="sg-x" type="hidden" name="x">
                    <input class="sg-y" type="hidden" name="y">
                    <button class="sg-delete"><i class='fa fa-trash-o'></i></button>
                </div>
            </form>
        </div>
        <div class="sg-btn-box sg-hide">
            <p>Empty</p>
        </div>
        <div class="sg-line-box sg-hide">
            <p>Empty</p>
        </div>
        <div class="sg-ps-box sg-hide">
            <p>Empty</p>
        </div>
        <div class="sg-other-box sg-hide">
            <p>Empty</p>
        </div>
    </div>
    <!-- Style Guide Buttons -->
    <div class="sg-buttons">
        <button class="sg-text" data-tool="sg-text">
            <i class='fa fa-i-cursor'></i>
        </button>
        <button class="sg-btn" data-tool="sg-btn">Button</button>
        <button class="sg-line" data-tool="sg-line">Line</button>
        <button class="sg-ps" data-tool="sg-ps"><i class='fa fa-paint-brush'></i></button>
        <button class="sg-other" data-tool="sg-other"><i class='fa fa-ellipsis-h'></i></button>
        <div class='clear'></div>
    </div> 
</div>
<!-- Style Guide SVG Surface -->
<svg id="sg-surface">
    <?php    
    $u = 0;
    $sql = "SELECT x, y, stylecolour, font FROM pagetitle";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $u++;
            echo '<circle class="sg-circle sg-circle-' . $u . '" cx="' . $row["x"] . '" cy="' . $row["y"] . '" r="20" fill="' . $row["stylecolour"] . '" /></circle>';
        }
    } 
    ?>
</svg>
<!-- Style Guide Notes -->
<div class="sg-notes"> 
    <?php  
    $u = 0;
    $sql = "SELECT x, y, stylecolour, fontsize, font, fontcolour, styletitle, id, additional FROM pagetitle";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {  
            $u++;
            $x = $row["x"] + 30;
            $y = $row["y"] - 20;
        echo '<div class="sg-view-' . $u . ' sg-view" style="left:' . $x . 'px;top:' . $y . 'px;"><table><tr><th colspan="2">' . $row["styletitle"] . '</th></tr><tr><td style="padding-top:10px">Font</td><td style="padding-top:10px">' . $row["font"] . '</td></tr><tr><td>Font Colour</td><td>' . $row["fontcolour"] . '</td></tr><tr><td>Font Size</td><td>' . $row["fontsize"] . 'px</td></tr><tr><td>Additional</td><td>' . $row["additional"] . '</td></tr><tr><td colspan="2"><form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '"><input name="remove" type="hidden" value="' . $row["id"] . '" /><input type="submit" name="removed" value="Remove" class="sg-remove" /></form></td></tr></table></div>';
        }
    }
    ?>
</div>
<?php if($insert === false){?>
    <div class="alert"><div>Style already taken.</div></div>
<?php } ?>
<script>
$(document).ready(function(){
    
    $('.sg-container').draggable();
    $('.sg-view').draggable();
    
    $('.sg-buttons button').click(function(){
        $('.sg-buttons button').removeClass('sg-active');
        $(this).addClass('sg-active');
    });
    
    function toolbarClick() {
        var tool = $(this).attr('data-tool') + "-box";
        $('.sg-hide').removeClass('open-tool');
        $('.' + tool).addClass('open-tool');
    } 
    
    $('.sg-text').click(toolbarClick);
    $('.sg-btn').click(toolbarClick);
    $('.sg-line').click(toolbarClick);
    $('.sg-ps').click(toolbarClick);
    $('.sg-other').click(toolbarClick);
     
    var documentHeight = $(document).height();
    var documentWidth = $(document).width();
    $('#sg-surface').height(documentHeight);
    $('#sg-surface').width(documentWidth);

    $('.sp-cf span').click(function(){
        var colourVal = $('.sp-preview-inner').attr('style');
        console.log('jelo');
        $('.sg-dot').css({ fill: colourVal });
    });
    
    $('.close').click(function(){
       $('.sg-container').fadeOut(); 
        $('.sg-dot').fadeOut(); 
    });
    
    $('#sg-surface').click(function(){
        
        var windowWidth = $(window).width();
        var toolbarWidth = $('.sg-container').width() + 30;
        
        var scrollVPos = $(document).scrollTop();
        var scrollHPost = $(document).scrollLeft();
        var tooClose = windowWidth - toolbarWidth;
        
        
        var x = event.clientX + scrollHPost;        
        var y = event.clientY + scrollVPos;

        if (tooClose > x) {
            $('.sg-container').css('left', x + 30);
            $('.sg-container').css('top', y - 20);
        } else {
            var x = event.clientX - 400;
            $('.sg-container').css('left', x - 30);
            $('.sg-container').css('top', y - 20);
        }
        
        $('.sg-container').show();
        
        var x = event.clientX + scrollHPost;        
        var y = event.clientY + scrollVPos;
        
        $( ".sg-dot" ).remove();
        var html = $('#sg-surface').html();
        
        $('#sg-surface').html(html + '<circle class="sg-dot" cx="' + x + '" cy="' + y + '" r="20" fill="#000" />'); 

        var cxVal = $('.sg-dot').attr('cx');
        $('.sg-x').val(cxVal);
        var cyVal = $('.sg-dot').attr('cy');
        $('.sg-y').val(cyVal);
        
        $('.sp-thumb-inner').click(function(){
           console.log('hello'); 
        });
        
    });
    
    $('.menu').click(function(){
        $('.nav').slideToggle();
        $('#menu').toggleClass('push');
        $('.menu').toggleClass('active');
    });
    
    var circles =  $('.sg-circle').length;
    
    $('.sp-container').width(400);
    
    setTimeout(function(){
        $('.alert').fadeOut();
    }, 2000);
    
    $('.sg-colour-input').change(function(){
        var colour = $('.sg-colour-input').val();
        console.log(colour);
        $('.sg-dot').css({ fill: colour });
    });
        
    
    
});

    
</script>

<script src="assets/js/jscolor.min.js"></script>

<?php 
           } 
include 'system/footer.php';
?>