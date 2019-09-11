<template>
    <div class="container">
        <div v-bind:class="{ succmsg: succmsg }">
            <div class="col-md-12 col-lg-12">
                <div class="alert alert-success">Classificação Incluída Com Sucesso</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7 com-lg-7  offset-md-3">
                <form method = "post" name="addclasificacao" id="addclasificacao" action="#" enctype="multipart/form-data" @submit.prevent="addClassificacao">
                    <div class="form-group">
                        <label for="code">Descrição</label>
                        <input type="text" name="description" id="description" class="form-control" placeholder="Descrição" v-model="classification.description"/>
                        {{ classification.description }}
                    </div>
                    <div class="form-group">
                        <label for="code">Código</label>
                        <input type="text" name="code" id="code" class="form-control" placeholder="Código" v-model="classification.code"/>
                    </div>
                    <div class="form-group">
                        <label for="type">tipo</label>
                        <select class="form-control" name="tipo" id="tipo" v-model="classification.type">
                            <option value="C">Crédito</option>
                            <option value="D">Débito</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="class">Classe</label>
                        <select class="form-control" name="class" id="class" v-model="classification.class">
                            <option value="A">Analitica</option>
                            <option value="S">Sintética</option>
                        </select>
                    </div>
                    <div class="form-group text-right">
                        <button class="btn btn-success">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>

    export default {

        data() {
            return {
                classificacao: {
                    'description': '',
                    'code': '',
                    'type': '',
                    'class': ''
                },
                succmsg:  true,
            }
        },
        methods: {
            addClassificacao() {
                this.$http.post('http://127.0.0.1:8081/financial/classification',{
                        'description': this.classification.description,
                        'code': this.classification.code,
                        'type': this.classification.type,
                        'class': this.classification.class
                    }).
                    then((data) => {
                        this.succmsg = false;
                        console.log(data);
                        this.classification.description = '';
                        this.classification.code = '';
                        this.classification.type = '';
                        this.classification.class = '';
                        var self = this;
                        setTimeout(function(){
                            self.succmsg = true;
                        },3000);
                    });
            }

        },
        computed: {
}
    }
</script>
<style scoped>
    .succmsg {
        display: none;
    }
</style>
