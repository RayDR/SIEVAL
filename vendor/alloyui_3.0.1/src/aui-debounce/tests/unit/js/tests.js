YUI.add('aui-debounce-tests', function(Y) {

    var suite = new Y.Test.Suite('aui-debounce');

    suite.add(new Y.Test.Case({
        name: 'Automated Tests',
        'test is empty': function() {
            Y.Assert.pass('No Tests Provided For This Module');
        }
    }));

    Y.Test.Runner.add(suite);

}, '', {
    requires: ['test']
});
