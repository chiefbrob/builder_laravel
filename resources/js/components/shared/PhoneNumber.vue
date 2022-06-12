<template>
    <div>
        <b-input-group
          
        >
        <template #prepend>
            <b-form-select @input="updated" v-model="code" :options="prefixOptions"></b-form-select>
      
        </template>
          <b-form-input
            id="phone_number"
            v-model="number"
            type="number"
            step="0"
            :required="required"
            :placeholder="`e.g. 712345678`"
            @input="updated"
          ></b-form-input>
        </b-input-group>
        <field-error :solid="false" :errors="errors" field="phone_number"></field-error>
    </div>
</template>

<script>
export default {
    props: {
        defaultNumber: {
            required: false,
            type: Number
        },
        errors: {
            required: false,
            default: ()=> []
        },
        required: {
            required: false,
            default: false
        }
    },
    data() {
        return {
            code: '254',
            number: null,
            prefixOptions: [
                { value: 254, text: 'KE +254' },
                { value: 243, text: 'DRC +243' },
                { value: 250, text: 'RW +250' },
                { value: 255, text: 'TZ +255' },
                { value: 257, text: 'BU +257' },
                { value: 256, text: 'UG +256' },
                { value: 1, text: 'USA +1' },
            ]
        }
    },
    methods: {
        updated() {
            this.$emit('updated', this.code + this.number);
        }
    }
}
</script>