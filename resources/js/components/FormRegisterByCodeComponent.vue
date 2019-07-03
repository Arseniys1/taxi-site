<template>
    <div id="form-register-by-code">
        <form>
            <div class="form-group">
                <label for="code">Код</label>
                <input type="text" class="form-control" id="code" placeholder="Код из SMS">
            </div>
            <button type="submit" class="btn btn-dark">Проверить</button>
        </form>
    </div>
</template>

<script>
    export default {
        name: "FormRegisterByCodeComponent",

        created() {
            window._form_register_by_code = this;
        },
    }
</script>

<style scoped>

</style>