import * as validators from '@vuelidate/validators';
import { createI18n } from "vue-i18n";

const { createI18nMessage } = validators;

const regexPostalCode = validators.helpers.regex(/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/i);
const regexFrenchPhone = validators.helpers.regex(/^(0)[6-7](\d{2}){4}$/i);

const messages = {
    fr: {
        validations: {
            required: "Le champ est requis",
            alphaNum: 'Le champ ne doit contenir que des caractères alphanumérique',
            maxStringSize: 'Le champs contient trop de caractères',
            url: 'L\'url n\'est pas valide',
            email: 'L\'email n\'a pas un format valide',
            postalCode: 'Le code postal n\'est pas valide',
            tel: 'Le téléphone doit être au format 06******** ou 07********' 
        }
    }
};

const i18n = createI18n({
    locale: "fr",
    messages
});

const withI18nMessage = createI18nMessage({ t: i18n.global.t.bind(i18n) });

export const required = withI18nMessage(validators.required);
export const alphaNum = withI18nMessage(validators.alphaNum);
export const maxStringSize = withI18nMessage(validators.maxLength(255));
export const url = withI18nMessage(validators.url);
export const postalCode = withI18nMessage(regexPostalCode);
export const tel = withI18nMessage(regexFrenchPhone);
export const email = withI18nMessage(validators.email);