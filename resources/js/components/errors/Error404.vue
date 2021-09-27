<template>
    <div>
        <nav-root></nav-root>
        <b-row>
            <b-col md="6" offset="3">
                <b-card
                    title="Snap, We Could't find it!"
                    img-src="https://picsum.photos/600/300/?image=25"
                    img-alt="Image"
                    img-top
                    tag="article"
                    class="mb-2"
                >
                    <b-card-text>
                        We're pretty sure this is an error on your side so check
                        domain for typos or search different keywords
                    </b-card-text>

                    <b-button
                        @click="$router.push({ name: 'home' })"
                        variant="info"
                        >Go Home</b-button
                    >
                </b-card>
            </b-col>
        </b-row>
    </div>
</template>

<script>
export default {};
</script>
