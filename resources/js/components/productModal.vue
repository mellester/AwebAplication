<template>
<div class="mgrid border min-h-8 grid gap-x-8 gap-y-4">
    <div id="expandButton"> 
        <button @click="isExpanded = !isExpanded">
            {{!isExpanded ? "expand" : "unexpand" }}
            </button>
    </div>
    <div id="name">
        {{product.name}}
    </div> 
    <div :class="isExpanded ? '' : 'hidden'" class="mdes">
        {{product.description}}
    </div>
</div>
</template>

<script>
export default {
    data() {
        return {
            isExpanded : false,
        }
    },
    props : {
        product : {
            type : Object,
            required : true,
        }
    }
}
</script>

<style scoped>
.mgrid {
    display: grid;
    grid-template-columns: 1fr 4fr 1fr ;
    grid-template-rows: auto ;
}
.mdes {
    grid-column: 1 / span 3;
    grid-row: 2;
}

.mgrid > div {
    height: 100%;
}
.btn-default {
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}
</style>