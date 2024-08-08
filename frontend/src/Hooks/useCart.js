import { createContext, useContext, useEffect, useState } from "react";

const CartContext = createContext();

export const CartProvider = ({ children }) => {
  const [cartData, setCartData] = useState([]);
  const [totalPrice, setTotalPrice] = useState(0);
  const addItem = (item) => {
    setCartData([...cartData, item]);
  };
  const deleteItem = (itemId) => {
    const newCart = cartData.filter((item) => item.p_id !== itemId);
    setCartData(newCart);
  };
  const editItem = (itemId, newNum) => {
    const newCart = [...cartData];
    const itemIndex = cartData.findIndex((p) => p.p_id === itemId);
    newCart[itemIndex].p_num = newNum;
    setCartData(newCart);
    changePrice();
  };
  const changePrice = (cart) => {
    if (cart === undefined) return;
    let price = 0;
    cart.map((item) => {
      price += item.p_num * item.p_price;
    });
    setTotalPrice(price);
  };

  useEffect(() => {
    if (cartData === undefined) return;
    changePrice(cartData);
  }, [cartData]);

  return (
    <CartContext.Provider
      value={{
        cartData,
        setCartData,
        addItem,
        deleteItem,
        editItem,
        totalPrice,
      }}
    >
      {children}
    </CartContext.Provider>
  );
};

export const useCart = () => {
  const context = useContext(CartContext);
  if (!context) {
    throw new Error("useCart must be used within a CartProvider");
  }
  return context;
};
