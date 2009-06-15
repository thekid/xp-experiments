public class MkStack {
  public static void main(String[] args) throws Exception {
    MkStack s= new MkStack();
    
    s.call(5);
  }
  
  protected void call(int i) throws Exception {
    if (i == 0) this.callInner();
    this.call(i -1);
  }
  
  protected void callInner() throws Exception {
    throw new Exception("Got me.");
  }
}