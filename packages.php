<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <!-- Heading for the Training Packages Page -->
    <h1>Our Training Packages</h1>

    <!-- Horizontal line styled with navy color -->
    <hr class="border-navy bg-navy">

    <!-- Container for the Page Content -->
    <div class="container-fluid">

        <!-- Search Bar -->
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="input-group mb-2">
                    <!-- Search input field -->
                    <input type="search" id="search" class="form-control form-control-border" placeholder="Search Package here...">
                    <div class="input-group-append">
                        <!-- Search button -->
                        <button type="button" class="btn btn-sm border-0 border-bottom btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- List of Packages -->
        <div class="list-group" id="package-list">

            <?php
            // Fetch all active packages (status=1) ordered by name
            $package = $conn->query("SELECT * FROM `package_list` where `status` = 1 order by `name` asc");
            while ($row = $package->fetch_assoc()):
            ?>
                <div class="text-decoration-none list-group-item rounded-0 package-item">
                    <a class="d-flex w-100 text-navy" href="#package_<?= $row['id'] ?>" data-toggle="collapse">

                        <div class="col-11">
                            <h3><b><?= ucwords($row['name']) ?></b></h3><!-- Display package name with first letter capitalized -->
                        </div>

                        <div class="col-1 text-right">
                            <i class="fa fa-plus collapse-icon"></i>
                        </div>
                    </a>

                    <div class="collapse" id="package_<?= $row['id'] ?>">
                        <hr class="border-navy">
                        <div class="mx-3">
                            <!-- Display Duration and Cost -->
                            <span class="mr-3 text-muted"><span class="fa fa-calendar"></span> <?= $row['training_duration'] ?></span>
                            <span class="text-muted"><span class="fa fa-tags"></span> <?= number_format($row['cost'], 2) ?></span>
                        </div>

                        <!-- Display Package Description -->
                        <p class="mx-3"><?= $row['description'] ?></p>
                    </div>
                </div>

            <?php endwhile; ?>

            <!-- If no packages found -->
            <?php if ($package->num_rows < 1): ?>
                <center><span class="text-muted">No package Listed Yet.</span></center>
            <?php endif; ?>

            <!-- Hidden Div to Show 'No Result' During Search -->
            <div id="no_result" style="display:none">
                <center><span class="text-muted">No package Listed Yet.</span></center>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            // When a collapse section is opened
            $('.collapse').on('show.bs.collapse', function() {
                // Close other open collapses
                $(this).parent().siblings().find('.collapse').collapse('hide')

                // Reset icons on other packages to "plus"
                $(this).parent().siblings().find('.collapse-icon').removeClass('fa-plus fa-minus')
                $(this).parent().siblings().find('.collapse-icon').addClass('fa-plus')

                // Change the opened item's icon to "minus"
                $(this).parent().find('.collapse-icon').removeClass('fa-plus fa-minus')
                $(this).parent().find('.collapse-icon').addClass('fa-minus')
            })

            // When a collapse section is closed
            $('.collapse').on('hidden.bs.collapse', function() {
                // Reset its icon to "plus"
                $(this).parent().find('.collapse-icon').removeClass('fa-plus fa-minus')
                $(this).parent().find('.collapse-icon').addClass('fa-plus')
            })

            // Search functionality
            $('#search').on("input", function(e) {
                var _search = $(this).val().toLowerCase() // Get user input in lowercase

                $('#package-list .package-item').each(function() {
                    var _txt = $(this).text().toLowerCase() // Get each package's text content

                    if (_txt.includes(_search) === true) {
                        $(this).toggle(true) // Show if it matches
                    } else {
                        $(this).toggle(false) // Hide if not matched
                    }

                    if ($('#package-list .package-item:visible').length <= 0) {
                        $("#no_result").show('slow')
                    } else {
                        $("#no_result").hide('slow')
                    }
                })
            })
        })
    </script>

</body>

</html>