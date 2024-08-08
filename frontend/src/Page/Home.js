import { Carousel, Layout } from "antd";
const { Content } = Layout;

const contentStyle = {
  height: "360px",
  color: "#fff",
  lineHeight: "360px",
  textAlign: "center",
  background: "#364d79",
};

const Home = () => {
  return (
    <Layout>
      <Content style={{ padding: "2rem 8rem" }}>
        <Carousel autoplay>
          <div>
            <h3 style={contentStyle}>1</h3>
          </div>
          <div>
            <h3 style={contentStyle}>2</h3>
          </div>
          <div>
            <h3 style={contentStyle}>3</h3>
          </div>
          <div>
            <h3 style={contentStyle}>4</h3>
          </div>
        </Carousel>
      </Content>
    </Layout>
  );
};

export default Home;
