<template>
    <div>
        <Header></Header>
        <Content></Content>
        <Footer></Footer>
    </div>
</template>
<script>
    import Header from './header/Header';
    import Content from './content/Content';
    import Footer from './footer/Footer';

    export default {
        components: {
            Header, Content, Footer
        },
    }
</script>