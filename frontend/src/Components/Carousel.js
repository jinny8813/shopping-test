import React, { useState, useEffect, useCallback, useRef } from "react";
import styled from "styled-components";

import { RightOutlined, LeftOutlined } from "@ant-design/icons";
import { Image as antdImage } from "antd";

const CarouselWrapper = styled.div`
  position: relative;
  display: flex;
  justify-content: center;
  width: ${(props) => props.$width}px;
  height: 400px;
  overflow: hidden;
`;

const ImageContainer = styled.div`
  width: 400px;
  height: 100%;
  overflow: hidden;
  position: relative;
  background: black;
`;

const ImageWrapper = styled.div`
  .ant-image {
    display: block;
  }

  .ant-image .ant-image-mask {
    left: ${(props) => props.$left}px;
    height: 400px;
    position: absolute;
    object-fit: cover;
    z-index: 15;
  }
`;

const Image = styled(antdImage)`
  left: ${(props) => props.$left}px;
  position: absolute;
  transition: all 0.4s ease;
  object-fit: cover;
`;

const ControlButtons = styled.div`
  color: #1677ff;
  position: absolute;
  z-index: 10;
  left: 0px;
  top: 0px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 100%;
  height: 100%;

  .anticon svg {
    cursor: pointer;
    width: 2rem;
    height: 2rem;
  }
`;

const Dots = styled.div`
  position: absolute;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 10;
  left: 50%;
  bottom: 8px;
  transform: translateX(-50%);
  & > *:not(:first-child) {
    margin-left: 6px;
  }
`;

const Dot = styled.div`
  border-radius: 100%;
  width: ${(props) => (props.$isCurrent ? 10 : 8)}px;
  height: ${(props) => (props.$isCurrent ? 10 : 8)}px;
  border: 1px solid #1677ff;
  background: ${(props) => (props.$isCurrent ? "#1677ff" : "none")};
  cursor: pointer;
  transition: all 0.2s ease-in-out;
`;

const Carousel = ({ dataSource }) => {
  const carouselRef = useRef();
  const [currentIndex, setCurrentIndex] = useState(0);
  const [imageWidth, setImageWidth] = useState(500);

  const getIndexes = () => {
    const prevIndex =
      currentIndex - 1 < 0 ? dataSource.length - 1 : currentIndex - 1;
    const nextIndex = (currentIndex + 1) % dataSource.length;
    return { prevIndex, nextIndex };
  };

  const makePosition = ({ itemIndex }) =>
    (itemIndex - currentIndex) * imageWidth;

  const clickPrevHandler = () => {
    const { prevIndex } = getIndexes();
    setCurrentIndex(prevIndex);
  };

  const clickNextHandler = useCallback(() => {
    const { nextIndex } = getIndexes();
    setCurrentIndex(nextIndex);
  }, [currentIndex]);

  const updateCarouselWidthHandler = () => {
    const carouselWidth = carouselRef.current.clientWidth;
    setImageWidth(carouselWidth);
  };

  useEffect(() => {
    updateCarouselWidthHandler();
    window.addEventListener("resize", updateCarouselWidthHandler);
    return () => {
      window.removeEventListener("resize", updateCarouselWidthHandler);
    };
  }, []);

  return (
    <CarouselWrapper ref={carouselRef} $width={imageWidth}>
      <ImageContainer>
        {dataSource.map((imageUrl, index) => {
          return (
            <ImageWrapper
              key={imageUrl}
              $left={makePosition({ itemIndex: index })}
            >
              <Image
                key={imageUrl}
                width={400}
                src={imageUrl}
                alt="商品圖"
                $left={makePosition({ itemIndex: index })}
                preview={{
                  src: imageUrl,
                }}
              />
            </ImageWrapper>
          );
        })}
      </ImageContainer>
      <ControlButtons>
        <LeftOutlined onClick={clickPrevHandler} />
        <RightOutlined onClick={clickNextHandler} />
      </ControlButtons>
      <Dots>
        {[...Array(dataSource.length).keys()].map((key, index) => (
          <Dot
            key={key}
            $isCurrent={index === currentIndex}
            onClick={() => setCurrentIndex(key)}
          />
        ))}
      </Dots>
    </CarouselWrapper>
  );
};

export default Carousel;
