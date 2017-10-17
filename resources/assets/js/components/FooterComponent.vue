<template>
    <div>
        <!-- Footer -->
        <footer class="navbar footer-size">
            <br/>
            <hr>
            <div class="text-center">
                <p>Copyright &copy; suri-markt.com {{currentDate | moment("YYYY")}} </p>
            </div>
            <br>
        </footer>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                currentDate: new Date()
            }
        },
        mounted() {
        },
        methods: {
        }
    }
</script>