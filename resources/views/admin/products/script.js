@section('script')

<script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.21/lodash.min.js"
    integrity="sha512-WFN04846sdKMIP5LKNphMaWzU7YpMyCU245etK3g/2ARYbPK9Ub18eG+ljU96qKRCWh+quCY7yefSmlkQw1ANQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="{{ asset('plugin/ckeditor5-build-classic/ckeditor.js') }}"></script>
<script>
$(() => {
    ClassicEditor
        .create(document.querySelector('#description'), {

            // toolbar: ['heading', '|', 'bold', 'italic', 'link']
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });
})
let sizes = [{
    id: Date.now(),
    size: 'M',
    quantity: 1
}];
</script>

<script src="{{ asset('admin/assets/js/product/product.js') }}"></script>
@endsection