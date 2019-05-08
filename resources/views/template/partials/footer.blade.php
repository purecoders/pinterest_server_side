<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
</body>
</html>
<script>
    window.onload = function () {
        var url = window.location.href;
        var inTagPage;
        if (url.includes("tag") || url.includes("getTag")) {
            document.getElementById('nav-link-user').classList.remove("active");
            document.getElementById('nav-link-tag').classList.add("active");
            inTagPage = true;
        }
        if (url.includes("user")) {
            document.getElementById('nav-link-tag').classList.remove("active");
            document.getElementById('nav-link-user').classList.add("active");
            inTagPage = false;
        }
        var tbl = document.getElementById("tblMain");
        for (var i = 0; i < tbl.rows.length; i++) {

            for (var j = 0; j < tbl.rows[i].cells.length; j++) {

                tbl.rows[i].cells[j].style.display = "";

                if (j == 1 && inTagPage)
                    tbl.rows[i].cells[j].style.display = "none";
                if (j == 2 && !inTagPage)
                    tbl.rows[i].cells[j].style.display = "none";

            }

        }
        var btnEdits = document.getElementsByClassName('tbl-tag-edit');
        var btnDeletes = document.getElementsByClassName('tbl-tag-delete');
        var btnBlocks = document.getElementsByClassName('tbl-tag-block');

        for (var i = 0; i < btnEdits.length; i++) {
            var btnEdit = btnEdits[i];
            var btnDelete = btnDeletes[i];
            btnEdit.onclick = function () {
                document.getElementById('edit-modal-tag-name').value = tbl.rows[this.parentNode.rowIndex].cells[2].innerHTML;
                document.getElementById('edit-form').action = {{\Illuminate\Support\Facades\URL::to('/')}}"/tag/" + tbl.rows[this.parentNode.rowIndex].cells[1].innerHTML;

            }
            btnDelete.onclick = function () {
                document.getElementById('delete-modal-tag-name').innerText = tbl.rows[this.parentNode.rowIndex].cells[2].innerHTML;
                document.getElementById('delete-form').action = "{{\Illuminate\Support\Facades\URL::to('/')}}/tag/" + tbl.rows[this.parentNode.rowIndex].cells[1].innerHTML;

            }
        }

        document.getElementById('btn-search').onclick = function () {
            if (document.getElementById('input-search').value == "") {
                alert("Can not be empty!!");
                this.href = "";
            } else {
                if (inTagPage) {

                    this.href = "{{\Illuminate\Support\Facades\URL::to('/')}}/getTag/" + document.getElementById('input-search').value;
                }else{
                    this.href = "{{\Illuminate\Support\Facades\URL::to('/')}}/getUser/" + document.getElementById('input-search').value;
                }

            }
        }

        for (var i = 0; btnBlocks.length; i++) {
            var btnBlock = btnBlocks[i];

            btnBlock.onclick = function () {

                document.getElementById('block-modal-user-name').innerText = tbl.rows[this.parentNode.rowIndex].cells[1].innerHTML;
                document.getElementById('block-form').action = "{{\Illuminate\Support\Facades\URL::to('/')}}/user/" + tbl.rows[this.parentNode.rowIndex].cells[2].innerHTML;
            }
        }

    };

    function validateAddTagForm() {
        var tagNameValue = document.getElementById('input-add-tag').value
        if (tagNameValue == "") {
            alert("Can not be empty!!");
            return false;
        }
    }

    $(".alert").alert()

</script>