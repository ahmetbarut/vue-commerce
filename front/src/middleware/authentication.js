export default () => {
    if (!localStorage.getItem('user')) {
        return false;
    }
    return true;
}