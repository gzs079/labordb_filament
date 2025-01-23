<x-filament-panels::page>


<div class="custom-content flex flex-col overflow-hidden bg-gray-100 p-6" id="custom-content">
    {{ $this->table }}
</div>



<script>

    console.log("?????")

    console.log(document.documentElement.clientWidth)
    console.log(document.documentElement.clientHeight)



    let page_height = document.getElementsByClassName("fi-page")[0].clientHeight
    let custom_content_top = document.getElementsByClassName("custom-content")[0].getBoundingClientRect().y
    console.log("page_height: " + page_height + 'px')
    console.log(custom_content_top)
    document.getElementsByClassName("custom-content")[0].style.height = (page_height-custom_content_top) + 'px'

</script>

</x-filament-panels::page>


