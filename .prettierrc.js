module.exports = {
    printWidth: 100,
    trailingComma: "all",
    singleQuote: true,
    semi: true,
    jsxBracketSameLine: false,
    bracketSpacing: true,
    tabWidth: 2,
    useTabs: false,
    vueIndentScriptAndStyle: true,
    overrides: [
        {
            files: "*.php",
            options: {
                tabWidth: 4,
                printWidth: 120,
                trailingCommaPHP: true
            }
        },
        {
            files: "*.yml",
            options: {
                singleQuote: false
            }
        }
    ]
};
